<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
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
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @category   Includes
 * @package    My_Wishlist_Plugin
 * @subpackage My_Wishlist_Plugin/includes
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */
class My_Wishlist_Plugin
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    My_Wishlist_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
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
        if (defined('MY_WISHLIST_PLUGIN_VERSION')) {
            $this->version = MY_WISHLIST_PLUGIN_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'my-wishlist-plugin';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        // add_action('init', array($this,'register_wishlist_post_type'));
        // add_action('init', array($this,'setup_wishlist_post_meta'));

        // Step 4: Handle Wishlist Actions
        add_action('wp_ajax_add_to_wishlist', [$this, 'add_to_wishlist_callback']);
        add_action('wp_ajax_nopriv_add_to_wishlist', [$this, 'add_to_wishlist_callback']);

        add_action('wp_ajax_remove_from_wishlist', [$this, 'remove_from_wishlist_callback']);
        add_action('wp_ajax_nopriv_remove_from_wishlist', [$this, 'remove_from_wishlist_callback']);
        add_filter('the_content', array($this, 'add_wishlist_icon_to_posts'), 10, 1);
        add_action('woocommerce_single_product_summary', array($this, 'add_wishlist_icon_to_products'), 10, 1);
        add_filter('woocommerce_add_to_cart_redirect', array($this, 'custom_redirect_after_add_to_cart'), 10, 1);
        add_shortcode('wishlist_page', [$this, 'display_wishlist_page']);
        add_shortcode('wishlist-menu', [$this, 'display_wishlist_shortcode']);
        add_action('admin_head', [$this,'wishlist_menu_icon_color']);
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - My_Wishlist_Plugin_Loader. Orchestrates the hooks of the plugin.
     * - My_Wishlist_Plugin_i18n. Defines internationalization functionality.
     * - My_Wishlist_Plugin_Admin. Defines all hooks for the admin area.
     * - My_Wishlist_Plugin_Public. Defines all hooks for the public side of the site.
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
        include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-my-wishlist-plugin-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-my-wishlist-plugin-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-my-wishlist-plugin-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'public/class-my-wishlist-plugin-public.php';

        $this->loader = new My_Wishlist_Plugin_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the My_Wishlist_Plugin_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     * 
     * @return String
     */
    private function set_locale()
    {

        $plugin_i18n = new My_Wishlist_Plugin_I18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
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

        $plugin_admin = new My_Wishlist_Plugin_Admin($this->get_plugin_name(), $this->get_version());

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

        $plugin_public = new My_Wishlist_Plugin_Public($this->get_plugin_name(), $this->get_version());

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
     * @return My_Wishlist_Plugin_Loader    Orchestrates the hooks of the plugin.
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
    function add_to_wishlist_callback()
    {

        global $wpdb;
        $table_name = $wpdb->prefix . 'cstmwishlist';
        $current_user_id = get_current_user_id();
        $post_id = isset($_POST['post_id']) ? sanitize_text_field(wp_unslash($_POST['post_id'])) : '';

        // Check if the post ID already exists in the wishlist
        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
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
    }

    /**
     * Show Remove to Wishlist in Wishlist Page.
     *
     * @since  1.0.0
     * @return string    The version number of the plugin.
     */
    function remove_from_wishlist_callback()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'cstmwishlist';
        $post_id = isset($_POST['post_id']) ? sanitize_text_field(wp_unslash($_POST['post_id'])) : '';
        $current_user_id = get_current_user_id();
        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared    
        $wpdb->delete(
            $table_name,
            array(
                'post_id' => $post_id,
                'user_id' => $current_user_id
            )
        );
        // Return success response
        wp_send_json_success();
    }

    
    function wishlist_menu_icon_color() {
        echo '<style>
            #adminmenu .dashicons-heart::before {
                color: #a31a1a !important; 
            }
        </style>';
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
    function add_wishlist_icon_to_posts($content)
    {
        if (is_user_logged_in()) {
            $all_post_name = get_option('we_filter_post_name');
            $wishlist_title = get_option('wishlist_name');
            $post = get_post_type(get_the_ID());
            // var_dump($post);
            $getPostType = $post;
            if (is_single() && $getPostType === $all_post_name) {
                $wishlist_icon = '<a href="#" class="wishlist-icon" data-post-id="' . get_the_ID() . '">' . $wishlist_title . '</a>';
                $content = $wishlist_icon . $content;
            }
            return $content;
        } else {
            echo '<a href="' . esc_url(wp_login_url()) . '" class="login">Login</a>';
        }
    }
    /**
     * Show Add to Wishlist in single products.
     * 
     * @param string $content The content of the Wishlist.
     *
     * @since  1.0.0
     * @return string    The version number of the plugin.
     */
    function add_wishlist_icon_to_products($content)
    {
        if (is_user_logged_in()) {
            $all_post_name = get_option('we_filter_post_name');
            $wishlist_title = get_option('wishlist_name');
            $post = get_queried_object();
            $getPostType = $post->post_type;
            if (is_single() && $getPostType === $all_post_name) {
                $wishlist_icon = '<a href="#" class="wishlist-icon" data-post-id="' . esc_attr(get_the_ID()) . '">' . $wishlist_title . '</a>';
                $content = $wishlist_icon . $content;
                echo wp_kses_post($content);
            }
        } else {
            echo '<a href="' . esc_url(wp_login_url()) . '" class="login">Login</a>';
        }
    }
    // Step 5: Create Wishlist Page
    /**
     * Shortcode function to display wishlist items.
     * Usage: [wishlist]
     *
     * @return string HTML markup of wishlist items.
     */
    function display_wishlist_page()
    {

        global $wpdb;


        if (!is_user_logged_in()) {
            echo '<a href="' . esc_url(wp_login_url()) . '" class="login">' . esc_html__('Login', 'wishlist-everywhere') . '</a>';
            return;
        }

        // Define the table name
        $current_user_id = get_current_user_id();
        $table_name = $wpdb->prefix . 'cstmwishlist';
        // Query to retrieve wishlist items using the Query API
        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $wishlist_items = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$table_name} WHERE user_id = %d",
                $current_user_id
            )
        );
        $remove_wishlist_title = get_option('we_removed_wishlist_label');
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
                    echo '<td style="text-align:center;">
                            <a href="#" class="wishlist-icon-remove" data-post-id="' . esc_attr($post->ID) . '" data-nonce="' . esc_attr($nonce) . '">🗑 ' 
                 . esc_html($remove_wishlist_title) . '</a>
                            ';
                    echo '<td>' . esc_html($post->post_title) . '</td>';
                    
                    if ($post->post_type === 'product' && function_exists('wc_get_product')) {
                        $product = wc_get_product($post->ID);
                        if ($product) {
                            $price = $product->get_price_html();
                            $add_to_cart_url = esc_url('?add-to-cart=' . $post->ID);
                            $add_to_cart_text = $product->add_to_cart_text();
                            echo '<td>
                                    <p><strong>Price:</strong> ' . wp_kses_post($price) . '</p>
                                  </td>';
                                  echo '<td>
                                  <a href="' . esc_attr($add_to_cart_url) . '" class="button add-to-cart-btn">' . esc_html($add_to_cart_text) . '</a>
                                </td>';                                  
                        // echo '<td>' . wp_kses_post(wpautop(wp_trim_words($post->post_content, 25))) . '</td>';
                        } else {
                            echo '<td>—</td>';
                        }
                    } else {

                    }
                    echo '<td><a class = "view" href="' . esc_url(get_permalink($post->ID)) . '">View</a></td>';
                    
                    echo '</tr>';
                }
            }
        
            echo '</tbody></table></div>';
            $first = false;
        }

        echo '</div>'; // .wishlist-wrapper


    }
    // Step 6: Create Wishlist icon with count which show in header
    /**
     * Shortcode function to display wishlist items.
     * Usage: [wishlist-menu]
     *
     * @return string HTML markup of wishlist items.
     */
    public function display_wishlist_shortcode()
    {
        global $wpdb;


        if (!is_user_logged_in()) {
            echo '<a href="' . esc_url(wp_login_url()) . '" class="login">' . esc_html__('Login', 'wishlist-everywhere') . '</a>';
            return;
        }

        // Define the table name
        $current_user_id = get_current_user_id();
        $table_name = $wpdb->prefix . 'cstmwishlist';
        // Query to retrieve wishlist items using the Query API
        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared        
        $wishlist_items = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$table_name} WHERE user_id = %d",
                $current_user_id
            )
        );
        $remove_wishlist_title = get_option('we_removed_wishlist_label');
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
            $grouped_items[$post_type][] = $post;
        }

        // Output tab navigation
        echo '<div class="wishlist-wrapper">';
        echo '<br><h1 align ="center">Wishlist</h1><br>';
        echo '<ul class="wishlist-tabs-nav">';
        $first = true;
        foreach ($grouped_items as $post_type => $posts) {
            $post_type_obj = get_post_type_object($post_type);
            $label = $post_type_obj ? $post_type_obj->labels->singular_name : ucfirst($post_type);
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
                    echo '<td style="text-align:center;">
                            <a href="#" class="wishlist-icon-remove" data-post-id="' . esc_attr($post->ID) . '" data-nonce="' . esc_attr($nonce) . '">🗑 ' 
                 . esc_html($remove_wishlist_title) . '</a>
                            ';
                    echo '<td>' . esc_html($post->post_title) . '</td>';
                    
                    if ($post->post_type === 'product') {
                        $product = wc_get_product($post->ID);
                        if ($product) {
                            $price = $product->get_price_html();
                            $add_to_cart_url = esc_url('?add-to-cart=' . $post->ID);
                            $add_to_cart_text = $product->add_to_cart_text();
                            echo '<td>
                                    <p><strong>Price:</strong> ' . wp_kses_post($price) . '</p>
                                  </td>';
                                  echo '<td>
                                  <a href="' . esc_attr($add_to_cart_url) . '" class="button add-to-cart-btn">' . esc_html($add_to_cart_text) . '</a>
                                </td>';                                  
                        // echo '<td>' . wp_kses_post(wpautop(wp_trim_words($post->post_content, 25))) . '</td>';
                        } else {
                            echo '<td>—</td>';
                        }
                    } else {

                    }
                    echo '<td><a class = "view" href="' . esc_url(get_permalink($post->ID)) . '">View</a></td>';
                    
                    echo '</tr>';
                }
            }
        
            echo '</tbody></table></div>';
            $first = false;
        }

        echo '</div>'; // .wishlist-wrapper
    }
}
