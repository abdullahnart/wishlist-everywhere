<?php

/**
 * The public-facing functionality of the plugin.
 * 
 * @category   Class
 * @package    Wishlist_Everywhere_Plugin
 * @subpackage Wishlist_Everywhere_Plugin/public
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
 * @package    Wishlist_Everywhere_Plugin
 * @subpackage Wishlist_Everywhere_Plugin/public
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */
class Wishlist_Everywhere_Plugin_Public
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
         * defined in Wishlist_Everywhere_Plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wishlist_Everywhere_Plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_register_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wishlist-everywhere-plugin-public.css', array(), $this->version, 'all');
        // wp_register_style('we_fontawesome', plugin_dir_url(__FILE__) . 'fontawesome/css/all.min.css', array(), $this->version, 'all');
        wp_register_style('we_fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name);
        wp_enqueue_style('we_fontawesome');

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
         * defined in Wishlist_Everywhere_Plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wishlist_Everywhere_Plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        // Register your main JS
        wp_register_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'js/wishlist-everywhere-plugin-public.js',
            array('jquery'),
            $this->version,
            true // load in footer
        );

        // Register SweetAlert2 (downgraded to v11.4.8 for privacy)
        // wp_register_script(
        //     'we_sweet_alert',
        //     plugin_dir_url(__FILE__) . 'js/sweetalert.js', // Make sure this is v11.4.8
        //     array('jquery'),
        //     '11.4.8',
        //     true
        // );
        wp_register_script(
            'we_sweet_alert',
            'https://cdn.jsdelivr.net/npm/sweetalert2@11', // Make sure this is v11.4.8
            array('jquery'),
            '11.23.0',
            true
        );

        // Optional: Add defer (WordPress 6.3+)
        if (function_exists('wp_script_add_data')) {
            wp_script_add_data('we_sweet_alert', 'defer', true);
            wp_script_add_data($this->plugin_name, 'defer', true);
        }

        // Enqueue
        wp_enqueue_script('we_sweet_alert');
        wp_enqueue_script($this->plugin_name);
        wp_localize_script($this->plugin_name, 'wishlistEverywhere_ajax', 
        array(
            'ajaxurl'=>admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('wishlist_nonce_action'),
        ));
        

        wp_localize_script($this->plugin_name, 'MyPluginData', array(
            'homeUrl' => home_url()
        ));
    }

}
