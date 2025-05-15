<?php

/**
 * The plugin bootstrap file
 *
 * @category Class
 * @package  Wishlist_Everywhere
 * @author   Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license  GNU General Public License version 2 or later; see LICENSE
 * @link     https://example.com
 * @since    1.0.0
 * 
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @wordpress-plugin
 * Plugin Name:       Wishlist Everywhere
 * Plugin URI:        https://example.com
 * Description:       A simple yet flexible plugin that enables wishlist functionality for all post types — including products, blog posts, or custom post types. Easily customize labels and manage user wishlists across your WordPress site.
 * Version:           1.0.0
 * Author:            Abdullah Naseem
 * Author URI:        https://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wishlist-everywhere
 * Domain Path:       /languages
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
 * This action is documented in includes/class-my-wishlist-plugin-activator.php
 * 
 * @return String
 */
function we_activate_plugin()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-my-wishlist-plugin-activator.php';
    My_Wishlist_Plugin_Activator::activate();

    global $wpdb;

    $page_name = 'Wishlist';
    $page_content = '[wishlist_page]';
    $page_slug = 'wishlist';
    $page_status = 'publish';

    $existing_page = get_posts(array(
        'post_type'   => 'page',
        'title'       => $page_name,
        'post_status' => 'publish',
        'numberposts' => 1
    ));
    
    $existing_page = !empty($existing_page) ? $existing_page[0] : null;
    if (!$existing_page) {
        $data = array(
            'post_title'   => $page_name,
            'post_content' => $page_content,
            'post_name'    => $page_slug,
            'post_status'  => $page_status,
            'post_type'    => 'page'
        );
    
        $wpdb->insert($wpdb->posts, $data);

    }

    $table_name = $wpdb->prefix . 'cstmwishlist';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        post_id bigint(20) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);

    // $wpdb->query($q);
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-my-wishlist-plugin-deactivator.php
 * 
 * @return String
 */
function we_deactivate_plugin()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-my-wishlist-plugin-deactivator.php';
    My_Wishlist_Plugin_Deactivator::deactivate();

    global $wpdb;

    // Define the table name
    $page_slug = 'wishlist';
    $deleted_query = $wpdb->prepare(
        "DELETE FROM {$wpdb->posts} 
        WHERE post_name = %s
        AND post_type = 'page'",
        $page_slug
    );
    // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
    $wpdb->query($deleted_query); 

    $page_slug = 'wishlist';
    $where = array(
        'post_name' => $page_slug,
        'post_type' => 'page'
    );
    $wpdb->delete($wpdb->posts, $where);

    $table_name = $wpdb->prefix . 'cstmwishlist';
    
    // Drop the table if it exists
    // $wpdb->query("DROP TABLE IF EXISTS $table_name");
}

register_activation_hook(__FILE__, 'we_activate_plugin');
register_deactivation_hook(__FILE__, 'we_deactivate_plugin');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * 
 * @return String
 */
require plugin_dir_path(__FILE__) . 'includes/class-my-wishlist-plugin.php';



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
function we_init_plugin()
{

    $plugin = new My_Wishlist_Plugin();
    $plugin->run();

}
we_init_plugin();
