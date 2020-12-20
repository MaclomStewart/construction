<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.upwork.com/fl/rayhan1
 * @since             1.0.0
 * @package           Different_Menus_In_Different_Page
 *
 * @wordpress-plugin
 * Plugin Name:       Different Menus in Different Pages
 * Plugin URI:        https://myrecorp.com
 * Description:       This plugin can set different menus in different post, pages, templates magically. You can set different menus in specific devices (android, iPhone, mobile and tablet) and it also supports in all theme like charm.
 * Version:           2.1.4
 * Author:            ReCorp
 * Author URI:        https://myrecorp.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       different-menus
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

	/**
	 * Currently plugin version.
	 * Rename this for your plugin and update it as you release new versions.
	 */
	define( 'DIFFERENT_MENUS_FOR_DIFFERENT_PAGE_VERSION', '2.1.4' );

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-different-menus-for-different-page-activator.php
	 */

	function activate_different_menus_for_different_page() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-different-menus-for-different-page-activator.php';
		Different_Menus_For_Different_Page_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-different-menus-for-different-page-deactivator.php
	 */

	function deactivate_different_menus_for_different_page() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-different-menus-for-different-page-deactivator.php';
		Different_Menus_For_Different_Page_Deactivator::deactivate();
	}

	register_activation_hook( __FILE__, 'activate_different_menus_for_different_page' );
	register_deactivation_hook( __FILE__, 'deactivate_different_menus_for_different_page' );

	register_activation_hook(__FILE__, 'recorp_different_menus_in_different_page_activate');
	add_action('admin_init', 'recorp_different_menu_plugin_redirect');

	register_activation_hook( __FILE__, 'rc_task_events_activate' );

	register_deactivation_hook( __FILE__, 'rc_task_events_deactivate' );
	  



	/*Redirect to plugin's settings page when plugin will active*/

	function recorp_different_menus_in_different_page_activate() {
	    add_option('recorp_different_menu_activation_check', true);
	}


	function recorp_different_menu_plugin_redirect() {
	    if (get_option('recorp_different_menu_activation_check', false)) {
	        delete_option('recorp_different_menu_activation_check');
	         exit( wp_redirect("options-general.php?page=different-menus-in-different-pages&welcome=true") );
	    }
	}
	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-different-menus-for-different-page.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */

	function run_different_menus_in_different_page() {

		$plugin = new Different_Menus_For_Different_Page();
		$plugin->run();

	}
	run_different_menus_in_different_page();


if( empty(get_option('is_trial_notice_clicked')) ){

	function recorp_trial_version_notice() {
	    ?>
	    <div class="notice notice-success dmidp_trial_notice is-dismissible">
	        <p><?php _e( '<strong>Different Menu in Different Pages</strong> has updated trial version download link. <a href="https://myrecorp.com/product/different-menus-in-different-pages-trial/?a=notice&clk=wp">Click Here to Download</a>', 'different-menus' ); ?></p>
	    </div>
	    <?php
	}
	//add_action( 'admin_notices', 'recorp_trial_version_notice' );

}