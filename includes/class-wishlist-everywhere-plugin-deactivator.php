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
    public static function deactivate() {
        global $wpdb;

        // --- 1. Delete the "Wishlist" and "Wishlist Share" pages ---
        $slugs = ['wishlist_page', 'wishlist-share'];

        foreach ($slugs as $slug) {
            $page = get_page_by_path($slug, OBJECT, 'page');
            if ($page) {
                wp_delete_post($page->ID, true); // true = force delete (bypass trash)
            }
        }

        // --- 2. Optionally remove custom table ---
        $table_name = $wpdb->prefix . 'cstmwishlist';
        // $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }


}
