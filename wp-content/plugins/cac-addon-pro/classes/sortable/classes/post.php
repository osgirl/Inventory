<?php

/**
 * Addon class
 *
 * @since 1.0
 */
class CAC_Sortable_Model_Post extends CAC_Sortable_Model {

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	function __construct( $storage_model ) {
		parent::__construct( $storage_model );

		// default sortby
		$this->default_orderby = 'menu_order title';

		// handle sorting request
		add_filter( 'request', array( $this, 'handle_sorting_request'), 1 );

		// register sortable headings
		add_filter( "manage_edit-{$this->storage_model->key}_sortable_columns", array( $this, 'add_sortable_headings' ) );

		// add reset button
		add_action( 'restrict_manage_posts', array( $this, 'add_reset_button' ) );
	}

	/**
	 * Get sortables
	 *
	 * @see CAC_Sortable_Model::get_sortables()
	 * @since 1.0
	 */
	function get_sortables() {

		$column_names = array(

			// WP default columns
			'author',
			'categories',
			'tags',
			'title',

			// Custom Columns
			'column-attachment',
			'column-attachment_count',
			'column-author_name',
			'column-before_moretag',
			'column-comment_count',
			'column-comment_status',
			'column-excerpt',
			'column-featured_image',
			'column-meta',
			'column-modified',
			'column-order',
			'column-page_template',
			'column-parent',
			'column-ping_status',
			'column-post_formats',
			'column-postid',
			'column-roles',
			'column-slug',
			'column-status',
			'column-sticky',
			'column-taxonomy',
			'column-word_count',
		);

		return $column_names;
	}

	/**
	 * Get posts sorted by taxonomy
	 *
	 * This will post ID's by the first term in the taxonomy
	 *
	 * @since 1.0
	 *
	 * @param string $post_type
	 * @param string $taxonomy
	 * @return array Posts
	 */
	function get_posts_sorted_by_taxonomy( $taxonomy = 'category' )	{
		$posts = array();

		foreach ( $this->get_posts() as $id ) {
			$posts[ $id ] = '';

			// add terms
			$terms = get_the_terms( $id, $taxonomy );
			if ( !is_wp_error( $terms ) && !empty( $terms ) ) {

				// use first term only
				$term = array_shift( array_values( $terms ) );
				if ( isset( $term->term_id ) ) {
					$posts[ $id ] = sanitize_term_field( 'name', $term->name, $term->term_id, $term->taxonomy, 'display' );
				}
			}
		}
		return $posts;
	}

	/**
	 * Get posts
	 *
	 * @since 1.0
	 *
	 * @param string $post_type
	 * @return array Posts
	 */
	public function get_posts() {

		$any_posts = (array) get_posts( array(
			'numberposts'	=> -1,
			'post_status'	=> 'any',
			'post_type'		=> $this->storage_model->key,
			'fields'		=> 'ids'
		));

		// trash posts are not included in the posts_status 'any' by default
		$trash_posts = (array) get_posts( array(
			'numberposts'	=> -1,
			'post_status'	=> 'trash',
			'post_type'		=> $this->storage_model->key,
			'fields'		=> 'ids'
		));

		$posts = array_unique( array_merge( $any_posts, $trash_posts ) );

		return $posts;
	}

	/**
	 * Admin requests for orderby column
	 *
	 * Only works for WP_Query objects ( such as posts and media )
	 *
	 * @since 1.0
	 *
	 * @param array $vars
	 * @return array Vars
	 */
	public function handle_sorting_request( $vars ) {

		global $pagenow;

		// only trigger on edit page
		if ( 'edit.php' != $pagenow )
			return $vars;

		// only handle request for this storage type
		if ( empty( $vars['post_type'] ) || $vars['post_type'] !== $this->storage_model->key )
			return $vars;

		$post_type = $vars['post_type'];

		// apply sorting preference
		$this->apply_sorting_preference( $vars );

		// no sorting
		if ( empty( $vars['orderby'] ) )
			return $vars;

		// Column
		$column = $this->get_column_by_orderby( $vars['orderby'] );

		if ( empty( $column ) )
			return $vars;

		// unsorted Posts
		$posts = array();

		switch ( $column->properties->type ) :

			// WP Default Columns
			case 'title' :
				$vars['orderby'] = 'title';
				break;

			case 'author' :
				$vars['orderby'] = 'author';
				break;

			case 'categories' :
				$sort_flag 	= SORT_STRING;
				$posts 		= $this->get_posts_sorted_by_taxonomy( 'category' );
				break;

			case 'tags' :
				$sort_flag 	= SORT_STRING;
				$posts 		= $this->get_posts_sorted_by_taxonomy( 'post_tag' );
				break;

			// Custom Columns
			case 'column-postid' :
				$vars['orderby'] = 'ID';
				break;

			case 'column-order' :
				$vars['orderby'] = 'menu_order';
				break;

			case 'column-modified' :
				$vars['orderby'] = 'modified';
				break;

			case 'column-comment_count' :
				$vars['orderby'] = 'comment_count';
				break;

			case 'column-excerpt' :
				$sort_flag = SORT_STRING;
				foreach ( $this->get_posts() as $id ) {
					if( ! $excerpt = get_post_field( 'post_excerpt', $id ) ) {
						$excerpt = trim( strip_tags( get_post_field( 'post_content', $id ) ) );
					}
					$posts[ $id ] = $this->prepare_sort_string_value( $excerpt );
				}
				break;

			case 'column-word_count' :
				$sort_flag = SORT_NUMERIC;
				break;

			case 'column-page_template' :
				$sort_flag = SORT_STRING;
				$templates = get_page_templates();
				foreach ( $this->get_posts() as $id ) {
					$page_template  = get_post_meta( $id, '_wp_page_template', true );
					$posts[ $id ] 	= array_search( $page_template, $templates );
				}
				break;

			case 'column-post_formats' :
				$sort_flag = SORT_REGULAR;
				foreach ( $this->get_posts() as $id ) {
					$posts[ $id ] = get_post_format( $id );
				}
				break;

			case 'column-attachment' :
			case 'column-attachment_count' :
				$sort_flag = SORT_NUMERIC;
				foreach ( $this->get_posts() as $id ) {

					$attachments = get_posts( array(
						'post_type' 	=> 'attachment',
						'numberposts' 	=> -1,
						'post_status' 	=> null,
						'post_parent' 	=> $id,
						'fields' 		=> 'ids'
					));

					$posts[ $id ] = count( $attachments );
				}
				break;

			// @todo: can be improved, slug will sort 'slug-93', 'slug-9' and then 'slug-83'.
			// needs sorting mix with string and numeric
			case 'column-slug' :
				$sort_flag = SORT_REGULAR;
				break;

			case 'column-sticky' :
				$sort_flag = SORT_REGULAR;
				$stickies = get_option( 'sticky_posts' );
				foreach ( $this->get_posts() as $id ) {
					$posts[ $id ] = $id;
					if ( ! empty( $stickies ) && in_array( $id, $stickies ) ) {
						$posts[ $id ] = 0;
					}
				}
				break;

			case 'column-featured_image' :
				$sort_flag = SORT_REGULAR;
				foreach ( $this->get_posts() as $id ) {
					$posts[ $id ] = $id;
					$thumb = get_the_post_thumbnail( $id );
					if ( ! empty( $thumb ) ) {
						$posts[ $id ] = 0;
					}
				}
				break;

			case 'column-roles' :
				$sort_flag = SORT_STRING;
				foreach ( $this->get_posts() as $id ) {
					$posts[ $id ] = 0;
					if ( $author = get_post_field( 'post_author', $id ) ) {
						$userdata = get_userdata( $author );
						if ( ! empty( $userdata->roles[0] ) ) {
							$posts[ $id ] = $userdata->roles[0];
						}
					}
				}
				break;

			case 'column-status' :
				$sort_flag = SORT_STRING;
				foreach ( $this->get_posts() as $id ) {
					$posts[ $id ] = $column->get_value( $id ) . strtotime( $id );
				}
				break;

			case 'column-comment_status' :
				$sort_flag = SORT_STRING;
				foreach ( $this->get_posts() as $id ) {
					$posts[ $id ] = get_post_field( 'comment_status', $id );
				}
				break;

			case 'column-ping_status' :
				$sort_flag = SORT_STRING;
				foreach ( $this->get_posts() as $id ) {
					$posts[ $id ] = $column->get_value( $id ) . strtotime( $id );
				}
				break;

			case 'column-taxonomy' :
				$sort_flag 	= SORT_STRING;
				$posts 		= $this->get_posts_sorted_by_taxonomy( $column->options->taxonomy );
				break;

			case 'column-author_name' :
				$sort_flag = SORT_STRING;
				if ( 'userid' == $column->options->display_author_as ) {
					$sort_flag  = SORT_NUMERIC;
				}
				break;

			case 'column-before_moretag' :
				$sort_flag = SORT_STRING;
				break;

			case 'column-parent' :
				$sort_flag = SORT_REGULAR;
				foreach ( $this->get_posts() as $id ) {
					$posts[ $id ] = get_post_field( 'post_parent', $id );
				}
				break;

			case 'column-meta' :

				// Post Title
				if ( 'title_by_id' == $column->options->field_type ) {
					$sort_flag = SORT_REGULAR;
					foreach ( $this->get_posts() as $id ) {

						// sort by the actual post_title instead of ID
						$meta 		= $column->get_meta_by_id( $id );
						$title_ids 	= $column->get_ids_from_meta( $meta );
						$title 		= isset( $title_ids[0] ) ? get_post_field( 'post_title', $title_ids[0] ) : '';

						$posts[ $id ] = $title;
					}
				}

				// Counter
				elseif( 'count' == $column->options->field_type ) {

					// available since cpac 2.0.3
					if ( method_exists( $column, 'get_raw_value' ) ) {

						$sort_flag = SORT_NUMERIC;
						foreach ( $this->get_posts() as $id ) {
							$count = $column->get_raw_value( $id, false );
							$posts[ $id ] = count( $count );
						}
					}
				}

				// Default
				else {

					$field_type = 'meta_value';

					if ( in_array( $column->options->field_type, array( 'numeric', 'library_id' ) ) )
						$field_type = 'meta_value_num';

					$vars = array_merge( $vars, array(
						'meta_key' 	=> $column->options->field,
						'orderby' 	=> $field_type
					));
				}

				break;

			// Try to sort by raw value.
			// Only used by added custom admin column throuhg the API
			default :

				// available since cpac 2.0.3
				if ( method_exists( $column, 'get_raw_value' ) ) {

					$sort_flag = SORT_REGULAR;
					foreach ( $this->get_posts() as $id ) {
						$posts[ $id ] = $column->get_raw_value( $id );
					}
				}

		endswitch;

		// we will add the sorted post ids to vars['post__in'] and remove unused vars
		if ( isset( $sort_flag ) ) {

			// orderby column value
			if ( ! $posts ) {
				foreach ( $this->get_posts() as $id ) {
					$posts[ $id ] = $this->prepare_sort_string_value( $column->get_value( $id ) );
				}
			}

			// set post__in vars
			$vars = $this->get_vars_post__in( $vars, $posts, $sort_flag );
		}

		return $vars;
	}
}