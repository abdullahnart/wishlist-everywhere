<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @category   Admin
 * @package    Wishlist_Everywhere_Plugin
 * @subpackage Wishlist_Everywhere_Plugin/admin
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 * 
 * @category   Admin
 * @package    Wishlist_Everywhere_Plugin
 * @subpackage Wishlist_Everywhere_Plugin/admin
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */
class Wishlist_Everywhere_Plugin_Admin
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
     * This function adds two numbers.
     * 
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     * 
     * @return String              The define of $num1 and $_versio.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;    
        add_action('admin_menu', [$this, 'wishlistItems']);
        // add_action('init', [$this, 'wishlist_add_gutenberg_block']);
        $this->wishlist_add_gutenberg_block();
        // add_action('elementor/widgets/widgets_registered', [$this, 'wishlist_everywhere_register_widget']);
    }

    /**
     * Register the stylesheets for the admin area.
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

        wp_register_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wishlist-everywhere-plugin-admin.css', array(), $this->version, 'all');
        wp_register_style('admin_fontawesome', plugin_dir_url(__FILE__) . 'fontawesome/css/all.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name);
        wp_enqueue_style('admin_fontawesome');


    }

    /**
     * Register the JavaScript for the admin area.
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
        
        wp_register_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'js/wishlist-everywhere-plugin-admin.js',
            array('jquery'),
            $this->version,
            true // load in footer
        );

        if (function_exists('wp_script_add_data')) {
            wp_script_add_data($this->plugin_name, 'defer', true);
        }
        wp_enqueue_script($this->plugin_name);

    }
    /**
     * Register Menu Option for the admin area.
     *
     * @since 1.0.0
     * 
     * @return String
     */
    public function wishlistItems()
    {
        add_menu_page('Wishlist', 'Wishlist Items', 'manage_options', 'wishlist_add', [$this,'wishlishFunc'], 'dashicons-heart', 25);
        add_submenu_page('wishlist_add', 'Wishlist Settings', 'Wishlist Settings', 'manage_options', 'wishev_shortcode', [$this,'wishlishShortode']);
    }
    /**
     * Enqueue File of admin display.
     *
     * @since 1.0.0
     * 
     * @return String
     */
    public function wishlishFunc()
    {

        return   include_once plugin_dir_path(__FILE__) . 'partials/wishlist-everywhere-plugin-admin-display.php';
    }
    /**
     * Enqueue File of admin shortcode.
     *
     * @since 1.0.0
     * 
     * @return String
     */
    public function wishlishShortode()
    {

        return   include_once plugin_dir_path(__FILE__) . 'partials/wishlist-everywhere-plugin-admin-shortcode-display.php';
    }

    public function wishlist_add_gutenberg_block(){

        return include_once plugin_dir_path(__FILE__) . 'partials/wishlist-everywhere-plugin-admin-gutenberg-block.php';
        
    }

    public function wishlist_everywhere_register_widget($widgets_manager){
        require_once plugin_dir_path(__FILE__) . 'partials/wishlist-everywhere-elementor-widget.php';
        $widgets_manager->register( new \Wishlist_Everywhere_Elementor_Widget() );
    }
}

