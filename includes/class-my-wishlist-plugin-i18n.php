<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @category   Includes
 * @package    My_Wishlist_Plugin
 * @subpackage My_Wishlist_Plugin/includes
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @category   Includes
 * @package    My_Wishlist_Plugin
 * @subpackage My_Wishlist_Plugin/includes
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */
class My_Wishlist_Plugin_I18n
{


    /**
     * Load the plugin text domain for translation.
     *
     * @since 1.0.0
     * 
     * @return String
     */
    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            'my-wishlist-plugin',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

    }



}
