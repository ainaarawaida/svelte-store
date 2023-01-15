<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://mypluginwp
 * @since             1.0.0
 * @package           Mypluginwp
 *
 * @wordpress-plugin
 * Plugin Name:       mypluginwp
 * Plugin URI:        https://mypluginwp
 * Description:       mypluginwp
 * Version:           1.0.0
 * Author:            mypluginwp
 * Author URI:        https://mypluginwp
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mypluginwp
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
define( 'MYPLUGINWP_VERSION', '1.0.0' );
define( 'MYPLUGINWP_PATH', plugin_dir_path( __FILE__ ) );
define( 'MYPLUGINWP_URL', plugins_url('mypluginwp') );

// $dbhost = "localhost";
// $dbuser = "x";
// $dbpass = "";
// $dbname = "x";
// $mydb2 = new wpdb($dbuser,$dbpass,$dbname,$dbhost);
// if(!$mydb2->error){
// 	$GLOBALS['mydb2'] = $mydb2 ; 
// }
	

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mypluginwp-activator.php
 */
function activate_mypluginwp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mypluginwp-activator.php';
	Mypluginwp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mypluginwp-deactivator.php
 */
function deactivate_mypluginwp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mypluginwp-deactivator.php';
	Mypluginwp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mypluginwp' );
register_deactivation_hook( __FILE__, 'deactivate_mypluginwp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mypluginwp.php';
require_once plugin_dir_path( __FILE__ ) . 'api/index.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mypluginwp() {

	$plugin = new Mypluginwp();
	$plugin->run();

}
run_mypluginwp();

function deb($data){
	print_r("<pre>");
	print_r($data);
}

