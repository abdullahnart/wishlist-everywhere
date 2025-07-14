<?php

/**
 * Fired during plugin deactivation
 *
 * @category   Includes
 * @package    Wishlist_Everywhere_Plugin
 * @subpackage Wishlist_Everywhere_Plugin/includes
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @category   Includes
 * @package    Wishlist_Everywhere_Plugin
 * @subpackage Wishlist_Everywhere_Plugin/includes
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */
class Wishlist_Everywhere_Plugin_Deactivator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since 1.0.0
     * 
     * @return String
     */
    public static function deactivate()
    {
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
    }

}
