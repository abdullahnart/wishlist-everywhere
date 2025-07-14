<?php

/**
 * Fired during plugin activation
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
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @category   Includes
 * @package    Wishlist_Everywhere_Plugin
 * @subpackage Wishlist_Everywhere_Plugin/includes
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */
class Wishlist_Everywhere_Plugin_Activator
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
    public static function activate()
    {

    global $wpdb;

    $page_name = 'Wishlist';
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

    }

}
