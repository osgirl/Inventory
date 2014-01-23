<?php
/*
Plugin Name: DB Form
Plugin URI: http://http://www.valentinalisch.de/dev_wp/db-form/
Description: Simple plugIn to submit entries to a database.
Version: 1.1.1
Author: Valentin Alisch
Author URI: http://www.valentinalisch.de
*/

//BACKEND
if(is_admin()){
	include_once('php/admin111.php');
	
	function dbf_admin_scripts() {
		wp_enqueue_script(
			'dbf-admin',
			plugins_url('', __FILE__) . '/js/admin111.js',
			array( 'jquery' ),
			null,
			true
		);
	}
	add_action( 'admin_enqueue_scripts', 'dbf_admin_scripts' );
	
	function dbf_admin_styles(){
		?>
	    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url('css/admin111.css',__FILE__); ?>" />
	    <?php	
	}
	add_action('admin_head', 'dbf_admin_styles');
}

//FRONTEND
if(!is_admin()){
	include_once('php/shortcodes111.php');
	
	function dbf_frontend_styles(){
		
		$dbf_stylesheet = get_option('dbf-0-stylesheet');
		if($dbf_stylesheet != 'none'){
			?>
			<link rel="stylesheet" type="text/css" href="<?php echo plugins_url($dbf_stylesheet); ?>" />
			<?php
		}
	}
	add_action('wp_head', 'dbf_frontend_styles');
}
?>