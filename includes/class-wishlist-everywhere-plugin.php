<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
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
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @category   Includes
 * @package    Wishlist_Everywhere_Plugin
 * @subpackage Wishlist_Everywhere_Plugin/includes
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */
class Wishlist_Everywhere_Plugin
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    Wishlist_Everywhere_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        if (defined('Wishlist_Everywhere_Plugin_VERSION')) {
            $this->version = Wishlist_Everywhere_Plugin_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'wishlist-everywhere-plugin';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->add_files_to_wishlist();
        // add_action('init', array($this,'register_wishlist_post_type'));
        // add_action('init', array($this,'setup_wishlist_post_meta'));

        // Step 4: Handle Wishlist Actions
        add_filter('woocommerce_login_redirect', [$this, 'custom_login_redirect'], 10, 2);
        add_filter('init', array($this, 'guest_user_wishlist'));
        add_filter('wp_login', array($this, 'wishev_merge_guest_wishlist_on_login'), 10, 2);
        // add_filter('woocommerce_add_to_cart_redirect', array($this, 'custom_redirect_after_add_to_cart'), 10, 1);
        add_action('admin_enqueue_scripts', [$this,'wishlist_menu_icon_color'], 10 , 1);
        add_filter('the_content',[$this,'wishlist_page_items']);
        add_filter('the_content',[$this,'wishlist_share']);
        add_action( 'wp_enqueue_scripts', array( $this, 'wishev_add_wishlist_custom_css' ), 20 );
        add_action('wp_footer',[$this,'wishlist_everywhere_js_data']);
        add_action('wp_footer',[$this,'wishlist_everywhere_js_data_single']);

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Wishlist_Everywhere_Plugin_Loader. Orchestrates the hooks of the plugin.
     * - Wishlist_Everywhere_Plugin_i18n. Defines internationalization functionality.
     * - Wishlist_Everywhere_Plugin_Admin. Defines all hooks for the admin area.
     * - Wishlist_Everywhere_Plugin_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     * 
     * @return String
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wishlist-everywhere-plugin-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wishlist-everywhere-plugin-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wishlist-everywhere-plugin-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'public/class-wishlist-everywhere-plugin-public.php';

        $this->loader = new Wishlist_Everywhere_Plugin_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Wishlist_Everywhere_Plugin_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     * 
     * @return String
     */
    private function set_locale()
    {

        $plugin_i18n = new Wishlist_Everywhere_Plugin_I18n();

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     * 
     * @return String
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Wishlist_Everywhere_Plugin_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueueStyles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueueScripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     * 
     * @return String
     */
    private function define_public_hooks()
    {

        $plugin_public = new Wishlist_Everywhere_Plugin_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueueStyles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueueScripts');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since 1.0.0
     * 
     * @return String
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since  1.0.0
     * @return string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since  1.0.0
     * @return Wishlist_Everywhere_Plugin_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since  1.0.0
     * @return string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Show Add to Wishlist in All post.
     *
     * @since  1.0.0
     * @return string    The version number of the plugin.
     */

    function guest_user_wishlist(){
        if (!session_id()) {
        session_start();
    }
    }

function wishev_merge_guest_wishlist_on_login($user_login, $user) {
    // Session already started via init
    if (isset($_SESSION['guest_wishlist']) && is_array($_SESSION['guest_wishlist'])) {
        error_log('Guest wishlist before merge: ' . print_r($_SESSION['guest_wishlist'], true));
        global $wpdb;
        $table_name = $wpdb->prefix . 'cstmwishlist';
        $table_name_analytics = $wpdb->prefix . 'cstmwishlist_logs';
        $user_id = $user->ID;

        foreach ($_SESSION['guest_wishlist'] as $post_id) {
            // Skip if already exists
            $exists = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(*) FROM {$table_name} WHERE post_id = %d AND user_id = %d",
                    $post_id,
                    $user_id
                )
            );

            if (!$exists) {
                // Add to analytics
                $wpdb->insert(
                    $table_name_analytics,
                    array(
                        'post_id' => $post_id,
                        'user_id' => $user_id,
                        'created_at' => current_time('mysql')
                    ),
                    array('%d','%d','%s')
                );

                // Add to main wishlist table
                $wpdb->insert(
                    $table_name,
                    array(
                        'post_id' => $post_id,
                        'user_id' => $user_id
                    ),
                    array('%d','%d')
                );
            }
        }

        // Optional: flag for frontend notification
        $_SESSION['guest_wishlist_merged'] = true;

        // Clear guest session
        unset($_SESSION['guest_wishlist']);
        error_log('Guest wishlist merged successfully for user ID: ' . $user_id);
    }
}

    
    /**
     * Show Remove to Wishlist in Wishlist Page.
     *
     * @since  1.0.0
     * @return string    The version number of the plugin.
     */
    function wishlist_menu_icon_color() {
        wp_register_style( 'wishlist-admin-style', false, [], $this->version ); // false means no file, just inline
        wp_enqueue_style( 'wishlist-admin-style' );
    
        $custom_css = '
            #adminmenu .dashicons-heart::before {
                color: #a31a1a !important;
            }
        ';
        wp_add_inline_style( 'wishlist-admin-style', $custom_css );
    }

    function custom_redirect_after_add_to_cart($url) {
        return wc_get_cart_url();
    }
    /**
     * Show Add to Wishlist in single posts.
     *
     * @param string $content The content of the Wishlist.
     * 
     * @since 1.0.0
     * 
     * @return string             The version number of the plugin.
     */

    /**
     * Show Add to Wishlist in single products.
     * 
     * @param string $content The content of the Wishlist.
     *
     * @since  1.0.0
     * @return string    The version number of the plugin.
     */
public function custom_login_redirect($redirect_to, $user) {
    if (!empty($_GET['redirect'])) {
        return esc_url_raw($_GET['redirect']);
    }
    return $redirect_to;
}


public function wishev_add_wishlist_custom_css() {

// 🔒 Ensure base stylesheet is enqueued FIRST
if ( ! wp_style_is( 'wishev-public-style', 'enqueued' ) ) {
    wp_enqueue_style(
        'wishev-public-style',
        plugin_dir_url( dirname( __FILE__ ) ) . 'public/css/wishlist-everywhere-plugin-public.css',
        array(),
        $this->version
    );
}

    $enable_css = get_option( 'enable_custom_css' );
    $custom_css = get_option( 'wishlist_custom_css' );

    $inline_css = '';

    // ✅ User custom CSS (do NOT strip everything)
    if ( 'custom_css' === $enable_css && ! empty( $custom_css ) ) {
        $inline_css .= trim( $custom_css ) . PHP_EOL;
    }

    // ✅ Button styles
    $button_font_size = absint( get_option( 'button_font_size', 18 ) );
    $button_bg_color  = sanitize_hex_color( get_option( 'button_bg_color' ) );
    $button_bg_color2 = sanitize_hex_color( get_option( 'button_bg_color_2' ) );
    $icon_color       = sanitize_hex_color( get_option( 'icon_color' ) );

    if ( $button_bg_color && $button_bg_color2 && $icon_color ) {
        $inline_css .= "
        .wishlist-icon {
            font-size: {$button_font_size}px;
            background: linear-gradient(180deg, {$button_bg_color} 0%, {$button_bg_color2} 100%);
            color: {$icon_color} !important;
        }";
    }

    // ✅ Attach inline CSS
    if ( ! empty( $inline_css ) ) {
        wp_add_inline_style( 'wishev-public-style', $inline_css );
    }
}

    // Step 5: Create Wishlist Page
    /**
     * Shortcode function to display wishlist items.
     * Usage: [wishlist]
     *
     * @return string HTML markup of wishlist items.
     */    

    function wishlist_page_items($content){
        if (is_page('wishlist_page')){
            $content.= do_shortcode('[wishlist_everywhere]');
        }

        return $content;
    }

        function wishlist_share($content){
        if (is_page('wishlist-share')){
            $content.= do_shortcode('[wishlist_share]');
        }

        return $content;
    }



function wishlist_everywhere_js_data() {
    if (is_user_logged_in()) {
        global $wpdb;
        $user_id = get_current_user_id();
        $table = $wpdb->prefix . 'cstmwishlist';

        $ids = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM {$table} WHERE user_id = %d", $user_id));
        echo '<script>var wishlistPostIds = ' . wp_json_encode($ids) . ';</script>';
        // echo '<script>var wishlistPostIds = ' . json_encode($ids) . ';</script>';
    } else {
        echo '<script>var wishlistPostIds = [];</script>';
    }
}


function wishlist_everywhere_js_data_single() {
    if (is_user_logged_in() && is_singular('product')) {
        global $wpdb;
        $user_id = get_current_user_id();
        $table = $wpdb->prefix . 'cstmwishlist';
        $product_id = get_the_ID();

        $is_in_wishlist = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE user_id = %d AND post_id = %d",
            $user_id,
            $product_id
        ));

        echo '<script>var isInWishlist = ' . ($is_in_wishlist ? 'true' : 'false') . ';</script>';
    } else {
        echo '<script>var isInWishlist = false;</script>';
    }
}

function add_files_to_wishlist(){
    require_once plugin_dir_path(__FILE__) . 'partials/wishlist-everywhere-ajax-add-remove.php';
    require_once plugin_dir_path(__FILE__) . 'partials/wishlist-everywhere-single-post.php';
    require_once plugin_dir_path(__FILE__) . 'partials/wishlist-everywhere-single-product.php';
    require_once plugin_dir_path(__FILE__) . 'partials/wishlist-everywhere-archive-product.php';
    require_once plugin_dir_path(__FILE__) . 'partials/wishlist-everywhere-display-wishlist-page.php';
    require_once plugin_dir_path(__FILE__) . 'partials/wishlist-everywhere-my-account-tab.php';
    require_once plugin_dir_path(__FILE__) . 'partials/wishlist-everywhere-sharing-wishlist.php';
    require_once plugin_dir_path(__FILE__) . 'partials/wishlist-everywhere-counter.php';
}

}
