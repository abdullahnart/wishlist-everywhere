<?php

/**
 * The plugin bootstrap file
 *
 * @category Class
 * @package  Wishlist_Everywhere
 * @author   Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license  GNU General Public License version 2 or later; see LICENSE
 * @link     https://github.com/abdullahnart/wishlist-everywhere
 * @since    1.0.0
 * 
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @wordpress-plugin
 * Plugin Name:       Wishlist Everywhere
 * Plugin URI:        https://github.com/abdullahnart/wishlist-everywhere
 * Description:       A simple yet flexible plugin that enables wishlist functionality for all post types — including products, blog posts, or custom post types. Easily customize labels and manage user wishlists across your WordPress site.
 * Version:           1.1.6
 * Author:            Abdullah Naseem
 * Author URI:        https://github.com/abdullahnart/wishlist-everywhere/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wishlist-everywhere
 * Domain Path:       /languages
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

// If this file is called directly, abort.
if (! defined('WPINC') ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WISHLIST_EVERYWHERE_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wishlist-everywhere-plugin-activator.php
 * 
 * @return String
 */
function wishev_activate_plugin()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-wishlist-everywhere-plugin-activator.php';
    Wishlist_Everywhere_Plugin_Activator::activate();

}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wishlist-everywhere-plugin-deactivator.php
 * 
 * @return String
 */
function wishev_deactivate_plugin()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-wishlist-everywhere-plugin-deactivator.php';
    Wishlist_Everywhere_Plugin_Deactivator::deactivate();
    
}

register_activation_hook(__FILE__, 'wishev_activate_plugin');
register_deactivation_hook(__FILE__, 'wishev_deactivate_plugin');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * 
 * @return String
 */
require plugin_dir_path(__FILE__) . 'includes/class-wishlist-everywhere-plugin.php';



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since  1.0.0
 * @return String
 */
function wishev_init_plugin()
{

    $plugin = new Wishlist_Everywhere_Plugin();
    $plugin->run();

}
wishev_init_plugin();



/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_wishlist_everywhere() {

    if ( ! class_exists( 'Appsero\Client' ) ) {
      require_once __DIR__ . '/includes/appsero/src/Client.php';
    }

    $client = new Appsero\Client( '67edb0fc-2749-4f95-a43f-5062ac3f566b', 'Wishlist Everywhere', __FILE__ );

    // Active insights
    $client->insights()->init();

}

appsero_init_tracker_wishlist_everywhere();
