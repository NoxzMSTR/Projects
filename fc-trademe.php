<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.forumcube.com/
 * @since             1.0.0
 * @package           Fc_Trademe
 *
 * @wordpress-plugin
 * Plugin Name:       FC Trademe
 * Plugin URI:        https://www.forumcube.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            ForumCube
 * Author URI:        https://www.forumcube.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fc-trademe
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
define( 'FC_TRADEME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fc-trademe-activator.php
 */
function activate_fc_trademe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fc-trademe-activator.php';
	Fc_Trademe_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fc-trademe-deactivator.php
 */
function deactivate_fc_trademe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fc-trademe-deactivator.php';
	Fc_Trademe_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fc_trademe' );
register_deactivation_hook( __FILE__, 'deactivate_fc_trademe' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fc-trademe.php';


require_once plugin_dir_path( __FILE__ ) . 'includes/modules/codestar-framework/classes/setup.class.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fc_trademe() {

	$plugin = new Fc_Trademe();
	$plugin->run();

}
run_fc_trademe();
