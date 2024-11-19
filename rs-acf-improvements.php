<?php
/*
Plugin Name: RS ACF Improvements
Description: Adds a link to edit field groups on user profiles and taxonomy term pages.
Version: 1.0.0
Author: Radley Sustaire
Author URI: https://radleysustaire.com
@todo GitHub Plugin URI: https://github.com/RadGH/RS-XXX
*/

define( 'RS_ACFI_PATH', __DIR__ );
define( 'RS_ACFI_URL', plugin_dir_url(__FILE__) );
define( 'RS_ACFI_VERSION', '1.0.0' );

class RS_ACF_Improvements {
	
	/**
	 * Checks that required plugins are loaded before continuing
	 *
	 * @return void
	 */
	public static function load_plugin() {
		// 1. Check for required plugins
		$missing_plugins = array();
		
		if ( ! class_exists('ACF') ) {
			$missing_plugins[] = 'Advanced Custom Fields Pro';
		}
		
		// Show error on the dashboard if any plugins are missing
		if ( $missing_plugins ) {
			self::add_admin_notice( '<strong>RS Font Awesome 5:</strong> The following plugins are required: '. implode(', ', $missing_plugins) . '.', 'error' );
			return;
		}
		
		// Add settings link to the plugins page
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(__CLASS__, 'add_settings_link') );
		
		// Load plugin files
		require_once( RS_ACFI_PATH . '/includes/setup.php' );
		
	}
	
	/**
	 * Adds an admin notice to the dashboard's "admin_notices" hook.
	 *
	 * @param string $message The message to display
	 * @param string $type    The type of notice: info, error, warning, or success. Default is "info"
	 * @param bool $format    Whether to format the message with wpautop()
	 *
	 * @return void
	 */
	public static function add_admin_notice( $message, $type = 'info', $format = true ) {
		add_action( 'admin_notices', function() use ( $message, $type, $format ) {
			?>
			<div class="notice notice-<?php echo $type; ?> rs-acf-improvements-notice">
				<?php echo $format ? wpautop($message) : $message; ?>
			</div>
			<?php
		});
	}
	
	/**
	 * Adds a settings link to the plugins page
	 *
	 * @param array $links The existing links
	 *
	 * @return array
	 */
	public static function add_settings_link( $links ) {
		// $settings_link = '<a href="options-general.php?page=settings-page-slug">Settings</a>';
		// array_unshift( $links, $settings_link );
		return $links;
	}
	
}

// Initialize the plugin
add_action( 'plugins_loaded', array('RS_ACF_Improvements', 'load_plugin') );
