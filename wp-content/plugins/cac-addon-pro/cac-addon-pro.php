<?php
/*
Plugin Name: 		Codepress Admin Columns - Pro add-on
Version: 			1.0.5
Description: 		Adds Pro functionality for Admin Columns.
Author: 			Codepress
Author URI: 		http://www.codepresshq.com
Plugin URI: 		http://www.codepresshq.com/wordpress-plugins/admin-columns/
Text Domain: 		cac-addon-pro
Domain Path: 		/languages
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'CAC_PRO_VERSION', 	 	'1.0.5' );
define( 'CAC_PRO_TEXTDOMAIN', 	'cac-addon-pro' );
define( 'CAC_PRO_URL', 			plugin_dir_url( __FILE__ ) );
define( 'CAC_PRO_DIR', 			plugin_dir_path( __FILE__ ) );

// only run plugin in the admin interface
if ( ! is_admin() )
	return false;

/**
 * Addon class
 *
 * @since 1.0
 *
 */
class CAC_Addon_Pro {

	private $plugin_basename;

	private $updater;

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	function __construct() {

		$this->plugin_basename = plugin_basename( __FILE__ );

		// init
		$this->init();

		// add to admin columns list
		add_filter( 'cac/addon_list', array( $this, 'add_addon' ) );

		// deactivate sortorder
		// add_action( 'plugins_loaded', array( $this, 'deactivate_sortorder_addon' ) );

		// translations
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		// add settings link
		add_filter( 'plugin_action_links',  array( $this, 'add_settings_link'), 1, 2);

		// Add notifications to the plugin screen
		add_action( 'after_plugin_row_' . $this->plugin_basename, array( $this, 'display_plugin_row_notices' ), 11 );
	}

	/**
	 * Init
	 *
	 * @since 1.0
	 */
	function init() {

		// Enables automatic plugin updates
		if ( ! class_exists('CAC_Addon_Update') ) {
			include_once 'classes/update.php';
			$this->updater = new CAC_Addon_Update( array(
				'store_url'			=> 'http://www.codepresshq.com',
				'product_id'		=> 'cac-pro',
				'version'			=> CAC_PRO_VERSION,
				'secret_key'		=> 'jhdsh23489hsdfkja9HHe',
				'product_name'		=> 'Pro Add-on',
				'file'				=> __FILE__
			));
		}

		if ( ! class_exists('CAC_Export_Import') ) {
			include_once 'classes/export-import/export-import.php';
		}
		if ( ! class_exists('CAC_Addon_Filtering') ) {
			include_once 'classes/filtering/filtering.php';
		}
		if ( ! class_exists('CAC_Addon_Sortable') ) {
			include_once 'classes/sortable/sortable.php';
		}
	}

	/**
	 * Add Settings link to plugin page
	 *
	 * @since 1.0.0
	 *
	 * @param string $links All settings links.
	 * @param string $file Plugin filename.
	 * @return string Link to settings page
	 */
	function add_settings_link( $links, $file ) {

		if ( ( ! $this->is_cpac_enabled() ) || ( $file != plugin_basename( __FILE__ ) ) )
			return $links;

		array_unshift( $links, '<a href="' . admin_url("options-general.php") . '?page=codepress-admin-columns&tab=settings">' . __( 'Settings' ) . '</a>' );
		return $links;
	}

	/**
	 * Deactivation notice
	 *
	 * @since 1.0
	 */
	function deactivation_notice() {
		 echo '<div class="updated"><p>' . __( "Sortorder has been <strong>deactivated</strong>. You are using the Pro add-on, which contains the same functionality.", CAC_PRO_TEXTDOMAIN ) . '</p></div>';
	}

	/**
	 * Deactivate
	 *
	 * @since 1.0
	 */
	function deactivate_sortorder_addon() {

		$sortorder = 'cac-addon-sortable/cac-addon-sortable.php';

		if( function_exists('is_plugin_active') && is_plugin_active( $sortorder ) ) {
			deactivate_plugins( $sortorder );

			add_action('admin_notices', array( $this, 'deactivation_notice' ) );
		}
	}

	/**
	 * Add Addon to Admin Columns list
	 *
	 * @since 1.0
	 */
	public function add_addon( $addons ) {

		$addons[ 'cac-addon-pro' ] = __( 'Pro add-on', CAC_PRO_TEXTDOMAIN );

		return $addons;
	}

	/**
	 * Load Textdomain
	 *
	 * @since 1.0.1
	 */
	function load_textdomain() {

		load_plugin_textdomain( CAC_PRO_TEXTDOMAIN, false, dirname( $this->plugin_basename ) . '/languages/' );
	}

	/**
	 * Main plugin is enabled
	 *
	 * @since 1.0.3
	 */
	function is_cpac_enabled() {

		return class_exists('CPAC');
	}

	/**
	 * Shows a message below the plugin on the plugins page
	 *
	 * @since 1.0.3
	 */
	function display_plugin_row_notices() {

		// Licence is not active
		if ( ! $this->updater->get_licence_status() ) {

			$latest_version = $this->updater->get_latest_version();

			// finish message
			$message = 'To finish activating Pro add-on, please ';

			// update message
			if ( $latest_version && version_compare( CAC_PRO_VERSION, $latest_version, '<' ) )
				$message = 'To update, ';

			$message .= 'go to ' . sprintf( '<a href="%s">%s</a>', network_admin_url( 'options-general.php?page=codepress-admin-columns&tab=settings' ), __( 'Settings', CAC_PRO_TEXTDOMAIN ) ) . ' and enter your licence key. If you don\'t have a licence key, you may <a href="http://www.codepresshq.com/wordpress-plugins/admin-columns/pro-add-on/">purchase one</a>.';

			?>
			<tr class="plugin-update-tr">
				<td colspan="3" class="plugin-update">
					<div class="update-message">
						<div class="error-notice">
							<?php echo $message; ?>
						</div>
					</div>
				</td>
			</tr>
			<?php
		}

		// Main plugin is not enabled
		if ( ! $this->is_cpac_enabled() ) {
			?>
			<tr class="plugin-update-tr">
				<td colspan="3" class="plugin-update">
					<div class="update-message">
						<div class="error-notice">
							<?php printf( __( 'The Pro add-on is enabled but not effective. It requires %s in order to work.', CAC_PRO_TEXTDOMAIN ), '<a href="' . admin_url('plugin-install.php') . '?tab=search&s=Codepress+Admin+Columns&plugin-search-input=Search+Plugins' . '">Codepress Admin Columns</a>'); ?>
						</div>
					</div>
				</td>
			</tr>
		<?php
		}
	}
}

new CAC_Addon_Pro();
