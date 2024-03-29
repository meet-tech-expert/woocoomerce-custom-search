<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Custom_Search
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Search
 * Plugin URI:        #
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Rinkesh
 * Author URI:        https://github.com/meet-tech-expert
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom-search
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_CS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custom-search-activator.php
 */
function activate_custom_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-search-activator.php';
	Custom_Search_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custom-search-deactivator.php
 */
function deactivate_custom_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-search-deactivator.php';
	Custom_Search_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_custom_search' );
register_deactivation_hook( __FILE__, 'deactivate_custom_search' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-custom-search.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_custom_search() {

	$plugin = new Custom_Search();
	$plugin->run();

}
run_custom_search();

require_once plugin_dir_path( __FILE__  ) . 'includes/class-autoupdate.php';
add_action( 'init', 'csearch_check_updates');
function csearch_check_updates(){
	$current_version = PLUGIN_CS_VERSION;
    $plugin_slug = plugin_basename(__FILE__);
    $plugin_remote_path = 'https://wp-plugin-factory.com/update/custom-search/update.php';
    $obj = new Csearch_auto_update($current_version, $plugin_remote_path, $plugin_slug);
}