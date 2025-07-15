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
        // add_action('init', array($this,'register_wishlist_post_type'));
        // add_action('init', array($this,'setup_wishlist_post_meta'));

        // Step 4: Handle Wishlist Actions
        add_filter('woocommerce_login_redirect', [$this, 'custom_login_redirect'], 10, 2);
        add_action('wp_ajax_add_to_wishlist', [$this, 'add_to_wishlist_callback']);
        add_action('wp_ajax_nopriv_add_to_wishlist', [$this, 'add_to_wishlist_callback']);
        add_action('wp_ajax_remove_from_wishlist', [$this, 'remove_from_wishlist_callback']);
        add_action('wp_ajax_nopriv_remove_from_wishlist', [$this, 'remove_from_wishlist_callback']);
        add_filter('the_content', array($this, 'add_wishlist_icon_to_posts'), 10, 1);
        add_filter('init', array($this, 'guest_user_wishlist'));
        $wishlist_single_position = get_option('wishlist_single_position');
        
        if($wishlist_single_position == 'before') {
            add_action('woocommerce_before_add_to_cart_button', array($this, 'add_wishlist_icon_to_product_single'), 10, 1);
        }elseif($wishlist_single_position == 'after'){
            add_action('woocommerce_after_add_to_cart_form', array($this, 'add_wishlist_icon_to_product_single'), 10, 1);
        }else{
            add_shortcode('wishlist_everywhere_single', array($this, 'add_wishlist_icon_to_product_single'));
        }

        $wishlist_position = get_option('wishlist_archive_position');
        if($wishlist_position == 'above_thumbnail') {
        add_action('woocommerce_before_shop_loop_item', array($this, 'add_wishlist_icon_to_product_archive'), 10, 1);
        }else if ($wishlist_position == 'before'){
        add_action('woocommerce_after_shop_loop_item', array($this, 'add_wishlist_icon_to_product_archive'), 10, 1);
        }else{
            add_shortcode('wishlist_everywhere_archive', array($this, 'add_wishlist_icon_to_product_archive'));
        }
        
        add_filter('woocommerce_add_to_cart_redirect', array($this, 'custom_redirect_after_add_to_cart'), 10, 1);
        add_shortcode('wishlist_everywhere', [$this, 'display_wishlist_page']);
        add_action('admin_enqueue_scripts', [$this,'wishlist_menu_icon_color'], 10 , 1);
        add_filter('the_content',[$this,'wishlist_page_items']);
        add_action('init',[$this,'register_wishlist_endpoint']);
        $enable_wishlist_myaccount = get_option('enable_wishlist_myaccount');
        if($enable_wishlist_myaccount === 'enable_wishlist_myaccount'){
            add_filter('woocommerce_account_menu_items',[$this,'add_wishlist_tab_to_my_account']);
            add_action('woocommerce_account_wishlist-everywhere_endpoint',[$this,'show_wishlist_tab_content']);
        }
        add_action('wp_head',[$this,'add_wishlist_custom_css']);
        add_action('wp_footer',[$this,'wishlist_everywhere_js_data']);

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

    function add_to_wishlist_callback()
    {

        // ✅ Verify nonce
        check_ajax_referer('wishlist_nonce_action', 'security');

        // ✅ Check user permission
        // if (!is_user_logged_in() || !current_user_can('read')) {
        //     wp_send_json_error('Unauthorized access');
        //     wp_die();
        // }

        global $wpdb;
        $table_name = $wpdb->prefix . 'cstmwishlist';
        $post_id = isset($_POST['post_id']) ? sanitize_text_field(wp_unslash($_POST['post_id'])) : '';
        
        // Check if the post ID already exists in the wishlist
        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        if(is_user_logged_in() && current_user_can('read')){
        $current_user_id = get_current_user_id();
        $existing_item = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$table_name} WHERE post_id = %d AND user_id = %d",
                $post_id,
                $current_user_id
            )
        );

        if (!$existing_item) {
            // If the post ID does not exist, insert it into the wishlist table
            // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $wpdb->insert(
                $table_name,
                array(
                    'post_id' => $post_id,
                    'user_id' => $current_user_id
                )
            );
            // Return success response
            wp_send_json_success();
        } else {
            // If the post ID already exists, return an error response
            wp_send_json_error('Post already exists in wishlist');
        }
    }else{
        // ✅ Guest user, save in PHP session
        if (!session_id()) {
            session_start();
        }

        if (!isset($_SESSION['guest_wishlist'])) {
            $_SESSION['guest_wishlist'] = [];
        }

        if (in_array($post_id, $_SESSION['guest_wishlist'])) {
            wp_send_json_error('Already in wishlist');
        } else {
            $_SESSION['guest_wishlist'][] = $post_id;
            wp_send_json_success('Added to wishlist');
        }
    }

        wp_die();
    }

    /**
     * Show Remove to Wishlist in Wishlist Page.
     *
     * @since  1.0.0
     * @return string    The version number of the plugin.
     */
    function remove_from_wishlist_callback()
    {

        // ✅ Verify nonce
    check_ajax_referer('wishlist_nonce_action', 'security');
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    if (!$post_id) {
        wp_send_json_error('Invalid product');
    }

        // ✅ Check user permission
        // if (!is_user_logged_in() || !current_user_can('read')) {
        //     wp_send_json_error('Unauthorized access');
        //     wp_die();
        // }

    if (is_user_logged_in() && current_user_can('read')) {
        // Logged-in user: remove from database
        global $wpdb;
        $table_name = $wpdb->prefix . 'cstmwishlist';

        $wpdb->delete(
            $table_name,
            array(
                'post_id' => $post_id,
                'user_id' => get_current_user_id()
            )
        );
        // Return success response
        wp_send_json_success('Removed from wishlist');
    }
    else{
        if(!session_id()){
            session_start();
        }
        
        if(!empty($_SESSION['guest_wishlist'])){
            $_SESSION['guest_wishlist'] = array_filter(
                $_SESSION['guest_wishlist'],
                function ($id) use ($post_id){
                    return intval($id) !== $post_id;
                }
            );
        }
        wp_send_json_success('Removed from wishlist');
    }
        wp_die();
    }

    
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
    function add_wishlist_icon_to_posts($content) {
        $all_post_name = get_option('wishev_filter_post_name');
        $post_type = get_post_type(get_the_ID());

        // Cast to array in case saved option is a single string
        $allowed_post_types = (array) $all_post_name;

        // Always return $content if not in allowed post types
        if (!in_array($post_type, $allowed_post_types, true)) {
            return $content;
        }

        if (is_single() && is_user_logged_in()) {
            $wishlist_title = get_option('wishlist_name', 'Add to Wishlist');
            $wishlist_icon = '<a href="#" class="wishlist-icon" data-post-id="' . esc_attr(get_the_ID()) . '">' . esc_html($wishlist_title) . '</a>';
            return $wishlist_icon . $content;
        }

        if (is_single() && !is_user_logged_in()) {
            $login_link = '<a href="' . esc_url(wp_login_url()) . '" class="login">Login to add to wishlist</a>';
            return $login_link . $content;
        }

        return $content;
    }


    /**
     * Show Add to Wishlist in single products.
     * 
     * @param string $content The content of the Wishlist.
     *
     * @since  1.0.0
     * @return string    The version number of the plugin.
     */
    function add_wishlist_icon_to_product_single($content)
    {
        $all_post_name = get_option('wishev_filter_post_name');
        $wishlist_title = get_option('wishlist_name');
        $wishlist_postion = get_option('wishlist_for_single');
        $required_login     = get_option('required_login');
        $post = get_queried_object();
        $wishlist_single_position = get_option('wishlist_single_position');
        if (!$post || empty($post->post_type)) return $content;

        
        $getPostType = $post->post_type;
        if ($getPostType !== $all_post_name) {
            return;
        }

        if($wishlist_postion !== 'single' && is_single()) {
            return;
        }
        if ($required_login === 'required_login') {
            // Only for logged-in users
            if (is_user_logged_in()) {
                    $wishlist_icon = '<a href="#" class="wishlist-icon" data-post-id="' . esc_attr(get_the_ID()) . '">' . $wishlist_title . '</a>';
                    $content = $wishlist_icon . $content;
                    echo wp_kses_post($content);
            } else {
        // Get the current URL to redirect back after login
                $current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                // var_dump($current_url);

                if (class_exists('WooCommerce')) {
                    // My Account page with redirect
                    $login_url = add_query_arg(
                        'redirect',
                        urlencode($current_url),
                        wc_get_page_permalink('myaccount')
                    );
                } else {
                    // Default WordPress login URL with redirect_to
                    $login_url = wp_login_url($current_url);
                }

                echo '<a href="' . esc_url($login_url) . '" class="login">Login</a>';
            }
        } else {
            // For guests
            // ✅ Session should already be started in init action
            // ✅ Mark added if already in session
            $added_class = '';
            if (!empty($_SESSION['guest_wishlist']) && in_array(get_the_ID(), $_SESSION['guest_wishlist'])) {
                $added_class = ' added';
            }

            $wishlist_icon = '<a href="#" class="wishlist-icon" data-post-id="' . esc_attr(get_the_ID()) . '">' . $wishlist_title . '</a>';
            $content = $wishlist_icon . $content;
            echo wp_kses_post($content);
        }                                 
                     

    }
public function custom_login_redirect($redirect_to, $user) {
    if (!empty($_GET['redirect'])) {
        return esc_url_raw($_GET['redirect']);
    }
    return $redirect_to;
}

function register_wishlist_endpoint(){
    add_rewrite_endpoint('wishlist-everywhere', EP_ROOT | EP_PAGES );
}
    
function add_wishlist_tab_to_my_account($items){
    $new_items = [];
    foreach($items as $key => $label){
        $new_items[$key] = $label;
    }
    
    // if($key === 'dashboard'){
        $new_items['wishlist-everywhere'] = __('My Wishlist', 'wishlist-everywhere');
    // }
    
    // var_dump($new_items);
    return $new_items;
}

function add_wishlist_custom_css(){
    $custom_css = get_option('wishlist_custom_css');
    if(!empty($custom_css)){
        echo '<style id="wishlist-everywhere-custom-css">' . wp_strip_all_tags($custom_css) . '</style>';
    }
}

function add_wishlist_icon_to_product_archive()
{
    $required_login     = get_option('required_login');
    $all_post_name      = get_option('wishev_filter_post_name');
    $wishlist_title     = get_option('wishlist_name');
    $wishlist_postion   = get_option('wishlist_for_archive');
    $wishlist_position  = get_option('wishlist_archive_position');
    $post               = get_queried_object();

    if (!$post || empty($post->name)) {
        return;
    }

    $getPostType = $post->name;

    if ($getPostType !== $all_post_name) {
        return;
    }

    if ($wishlist_postion !== 'archive' || !is_archive()) {
        return;
    }

    // Choose class for position
    $position_class = $wishlist_position === 'above_thumbnail' ? 'above_thumbnail' : 'no_thumbnail';
    $wishlist_icon_option = get_option('wishlist_custom_icon');
    if ($required_login === 'required_login') {
        // Only for logged-in users
        if (is_user_logged_in()) {
            if($wishlist_icon_option === 'text_only'){
                $wishlist_icon = '<div class="shop_wishlist_wrap ' . esc_attr($position_class) . '">
                    <a href="#" class="wishlist-icon archive" data-post-id="' . esc_attr(get_the_ID()) . '">' . esc_html($wishlist_title) . '</a>
                </div>';
                echo wp_kses_post($wishlist_icon);
            }else if($wishlist_icon_option === 'icon_only'){
                $wishlist_icon = '<div class="shop_wishlist_wrap ' . esc_attr($position_class) . '">
                    <a href="#" class="wishlist-icon archive" data-post-id="' . esc_attr(get_the_ID()) . '"><i class="fa-regular fa-heart"></i></a>
                </div>';
                echo wp_kses_post($wishlist_icon);
            }else{
                $wishlist_icon = '<div class="shop_wishlist_wrap ' . esc_attr($position_class) . '">
                    <a href="#" class="wishlist-icon archive" data-post-id="' . esc_attr(get_the_ID()) . '"> <i class="fa-regular fa-heart"></i>' . esc_html($wishlist_title) . '</a>
                </div>';
                echo wp_kses_post($wishlist_icon);
            }


        } else {
    // Get the current URL to redirect back after login
            $current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            // var_dump($current_url);

            if (class_exists('WooCommerce')) {
                // My Account page with redirect
                $login_url = add_query_arg(
                    'redirect',
                    urlencode($current_url),
                    wc_get_page_permalink('myaccount')
                );
            } else {
                // Default WordPress login URL with redirect_to
                $login_url = wp_login_url($current_url);
            }

            echo '<a href="' . esc_url($login_url) . '" class="login">Login</a>';
        }
    } else {
        // For guests
        // ✅ Session should already be started in init action
        // ✅ Mark added if already in session
        $added_class = '';
        if (!empty($_SESSION['guest_wishlist']) && in_array(get_the_ID(), $_SESSION['guest_wishlist'])) {
            $added_class = ' added';
        }
        if($wishlist_icon_option === 'text_only'){
            $wishlist_icon = '<div class="shop_wishlist_wrap ' . esc_attr($position_class) . '">
                <a href="#" class="wishlist-icon archive' . esc_attr($added_class) . '" data-post-id="' . esc_attr(get_the_ID()) . '">' . esc_html($wishlist_title) . '</a>
            </div>';
            echo wp_kses_post($wishlist_icon);
        }else if($wishlist_icon_option === 'icon_only'){
            $wishlist_icon = '<div class="shop_wishlist_wrap ' . esc_attr($position_class) . '">
                <a href="#" class="wishlist-icon archive' . esc_attr($added_class) . '" data-post-id="' . esc_attr(get_the_ID()) . '"><i class="fa-regular fa-heart"></i></a>
            </div>';
            echo wp_kses_post($wishlist_icon);
        }else{
            $wishlist_icon = '<div class="shop_wishlist_wrap ' . esc_attr($position_class) . '">
                <a href="#" class="wishlist-icon archive' . esc_attr($added_class) . '" data-post-id="' . esc_attr(get_the_ID()) . '"> <i class="fa-regular fa-heart"></i> ' . esc_html($wishlist_title) . '</a>
            </div>';
            echo wp_kses_post($wishlist_icon);
        }

    }
}

    // Step 5: Create Wishlist Page
    /**
     * Shortcode function to display wishlist items.
     * Usage: [wishlist]
     *
     * @return string HTML markup of wishlist items.
     */
    function display_wishlist_page($atts)
    {

    global $wpdb;

    $atts = shortcode_atts(
        array(
            'post_type' => '',
        ),
        $atts,
        'wishlist_everywhere'
    );


    $allowed_post_types = array();
    if (!empty($atts['post_type'])) {
        $allowed_post_types = array_map('sanitize_text_field', explode(',', $atts['post_type']));
    }
    // Guest or logged-in?
    $is_logged_in = is_user_logged_in();
    $current_user_id = get_current_user_id();
    $remove_label = get_option('wishev_removed_wishlist_label', __('Remove', 'wishlist-everywhere'));

    $wishlist_items = [];

    if ($is_logged_in) {
        // Get wishlist from the database
        $table_name = $wpdb->prefix . 'cstmwishlist';
        $wishlist_items = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$table_name} WHERE user_id = %d",
                $current_user_id
            )
        );
    } else {
        // Guest wishlist from session
        if (!session_id()) {
            session_start();
        }
        if (!empty($_SESSION['guest_wishlist'])) {
            // Format same way as DB rows (so code below works uniformly)
            $wishlist_items = array_map(function($post_id) {
                return (object)['post_id' => $post_id];
            }, $_SESSION['guest_wishlist']);
        }
    }
        $remove_wishlist_title = get_option('wishev_removed_wishlist_label');
        if (empty($wishlist_items)) {
            echo '<p>' . esc_html__('No items in wishlist', 'wishlist-everywhere') . '</p>';
            return;
        }

        // Group wishlist items by post type
        $grouped_items = [];

        foreach ($wishlist_items as $item) {
            $post = get_post($item->post_id);
            if (!$post) continue;

            $post_type = $post->post_type;

            // Skip 'product' if WooCommerce is not active
            if ($post_type === 'product' && !class_exists('WooCommerce')) {
                continue;
            }

            // If post_type filter is provided, skip others
            if (!empty($allowed_post_types) && !in_array($post_type, $allowed_post_types, true)) {
                continue;
            }

            $grouped_items[$post_type][] = $post;
        }

        // Output tab navigation
        echo '<div class="wishlist-wrapper">';
        echo '<br><h1 align="center">Wishlist</h1><br>';
        echo '<ul class="wishlist-tabs-nav">';
        $first = true;

        foreach ($grouped_items as $post_type => $posts) {
            // Double-check in case grouped_items already had 'product'
            if ($post_type === 'product' && !class_exists('WooCommerce')) {
                continue;
            }

            $post_type_obj = get_post_type_object($post_type);
            if (!$post_type_obj) {
                continue;
            }
            $label = $post_type_obj->labels->singular_name;

            echo '<li class="wishlist-tab-nav-item' . ($first ? ' active' : '') . '">
                    <a href="#tab-' . esc_attr($post_type) . '">' . esc_html($label) . '</a>
                </li>';
            $first = false;
        }
        echo '</ul>';


        // Output tab content
        $first = true;
        foreach ($grouped_items as $post_type => $posts) {
            echo '<div id="tab-' . esc_attr($post_type) . '" class="wishlist-tab-content" style="' . ($first ? '' : 'display:none;') . '">';
        
            echo '<table class="wishlist-table">
            <thead>
                <tr>';
        
        if ($post_type === 'product') {
            echo '
                    <th style="width:250px;">Action</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Add to Cart</th>
                    <th>View Page</th>';
        } else {
            echo '
                    <th style="width:250px;">Action</th>
                    <th>Title</th>
                    <th>View Page</th>';
        }
        
        echo '
                </tr>
            </thead>
            <tbody>';
        
if (!empty($posts) && is_array($posts)) {
    foreach ($posts as $post) {
        $nonce = wp_create_nonce('remove_wishlist_item_' . $post->ID);

        echo '<tr>';

        // 🗑 Remove icon
        echo '<td style="text-align:center;">
                <a href="#" class="wishlist-icon-remove" data-post-id="' . esc_attr($post->ID) . '" data-nonce="' . esc_attr($nonce) . '">🗑 ' . esc_html($remove_wishlist_title) . '</a>
              </td>';

        // 🏷 Title
        echo '<td>' . esc_html($post->post_title) . '</td>';

        // 📦 WooCommerce product handling
        if ($post->post_type === 'product' && function_exists('wc_get_product')) {
            $product = wc_get_product($post->ID);

            if ($product) {
                $price = $product->get_price_html();
                echo '<td><p><strong>Price:</strong> ' . wp_kses_post($price) . '</p></td>';

                // 🛒 Add to Cart Column
                echo '<td class = "var_product">';

                if ($product->is_type('variable')) {
                    $default_attributes = $product->get_default_attributes();
                    $available_variations = $product->get_available_variations();

                    $variation_id = null;
                    $query_args = ['add-to-cart' => $product->get_id()];

                    foreach ($available_variations as $variation) {
                        $variation_obj = wc_get_product($variation['variation_id']);
                        if (!$variation_obj || !$variation_obj->variation_is_active()) continue;

                        $match = true;
                        foreach ($default_attributes as $key => $value) {
                            if ($variation['attributes']['attribute_' . $key] !== $value) {
                                $match = false;
                                break;
                            }
                        }

                        if ($match) {
                            $variation_id = $variation['variation_id'];
                            foreach ($default_attributes as $key => $value) {
                                $query_args['attribute_' . $key] = $value;
                            }
                            $query_args['variation_id'] = $variation_id;
                            break;
                        }
                    }

                    if ($variation_id) {
                        $add_to_cart_url = esc_url(add_query_arg($query_args, wc_get_cart_url()));
                        $add_to_cart_text = $product->add_to_cart_text();
                        echo '<a href="' . $add_to_cart_url . '" class="button add-to-cart-btn">' . esc_html($add_to_cart_text) . '</a>';
                    } else {
                        echo '<span class="button disabled">Select Options</span>';
                    }

                } elseif ($product->is_purchasable() && $product->is_in_stock()) {
                    $add_to_cart_url = esc_url('?add-to-cart=' . $product->get_id());
                    $add_to_cart_text = $product->add_to_cart_text();
                    echo '<a href="' . $add_to_cart_url . '" class="button add-to-cart-btn">' . esc_html($add_to_cart_text) . '</a>';
                } else {
                    echo '<span class="button disabled">Out of Stock</span>';
                }

                echo '</td>';
            } else {
                echo '<td colspan="2">—</td>';
            }
        }

        // 🔗 View link
        echo '<td><a class="view" href="' . esc_url(get_permalink($post->ID)) . '">View</a></td>';

        echo '</tr>';
    }
}

        
            echo '</tbody></table></div>';
            $first = false;
        }

        echo '</div>'; // .wishlist-wrapper


    }
    

    function wishlist_page_items($content){
        if (is_page('wishlist_page')){
            $content.= do_shortcode('[wishlist_everywhere]');
        }

        return $content;
    }

    
    function show_wishlist_tab_content(){

    echo do_shortcode('[wishlist_everywhere post_type = "product"]');
}

function wishlist_everywhere_js_data() {
    if (is_user_logged_in()) {
        global $wpdb;
        $user_id = get_current_user_id();
        $table = $wpdb->prefix . 'cstmwishlist';

        $ids = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM {$table} WHERE user_id = %d", $user_id));
        echo '<script>var wishlistPostIds = ' . json_encode($ids) . ';</script>';
    } else {
        echo '<script>var wishlistPostIds = [];</script>';
    }
}

}
