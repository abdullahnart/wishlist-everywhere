<?php

/**
 * The public-facing functionality of the plugin.
 * 
 * @category   Class
 * @package    My_Wishlist_Plugin
 * @subpackage My_Wishlist_Plugin/public
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @category   Class
 * @package    My_Wishlist_Plugin
 * @subpackage My_Wishlist_Plugin/public
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */
class My_Wishlist_Plugin_Public
{

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version     The version of this plugin.
     * 
     * @since 1.0.0
     * 
     * @return String
     */
    public function __construct( $plugin_name, $version )
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since 1.0.0
     * 
     * @return String
     */
    public function enqueueStyles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in My_Wishlist_Plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The My_Wishlist_Plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/my-wishlist-plugin-public.css', array(), $this->version, 'all');
        wp_enqueue_style('we_fontawesome', plugin_dir_url(__FILE__) . 'css/fontawesome.min.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since 1.0.0
     * 
     * @return String
     */
    public function enqueueScripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in My_Wishlist_Plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The My_Wishlist_Plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/my-wishlist-plugin-public.js', array( 'jquery' ), $this->version, false);
        wp_enqueue_script('we_sweet_alert', plugin_dir_url(__FILE__) .  'js/sweetalert.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name, 'customWishlistAjax', array('ajaxurl'=>admin_url('admin-ajax.php')));
        


    }

}
