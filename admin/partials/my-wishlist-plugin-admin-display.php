<?php
/**
 * This function is provided for admin area only and dropdown.
 * 
 * @category   Partial Admin
 * @package    My_Wishlist_Plugin
 * @subpackage My_Wishlist_Plugin/admin/partials
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 * 
 * @return String
 */
// function Wishlish_func()
// {
//     $wishlist_post_types = get_post_types(
//         array(
//             'public' => true,
//         ), 'names'
//     );
//     unset($wishlist_post_types['attachment']);
//     unset($wishlist_post_types['page']);
//     // $postType = isset($_POST['filter_post_type']) ? $_POST['filter_post_type'] : ''; // Get selected post type

//     if (isset($_POST['post_submit'])) {
//         update_option('we_filter_post_name', $_POST['filter_post_type'], true);
//         if (!empty($_POST['wishlist_title'])) {
//             update_option('wishlist_name', sanitize_text_field($_POST['wishlist_title']), true);
//         }
//         if (!empty($_POST['remove_wishlist_title'])) {
//             update_option('we_removed_wishlist_label', sanitize_text_field($_POST['remove_wishlist_title']), true);
//         }
//     }

//     $wishlist_post_name = get_option('we_filter_post_name');
//     $wishlist_title = get_option('wishlist_name');
//     $remove_wishlist_title = get_option('we_removed_wishlist_label');
//     // $wishlist_post_placeholder = get_option('post_placeholder')
//     // var_dump($wishlist_title);

//     unset($wishlist_post_types[$wishlist_post_name]);
//     if ($wishlist_post_types) { // If there are any custom public post types.
//         $dropdown_val = '';
//         $dropdown_val .= '<option value="' . esc_attr($wishlist_post_name) . '" selected>' . esc_html($wishlist_post_name) . '</option>';
//         foreach ($wishlist_post_types as $wishlist_post_type) {
//             $dropdown_val .= '<option value ="' . esc_attr($wishlist_post_type) . '">' . esc_html($wishlist_post_type) . '</option>';
//         }
//     }

//     echo '<div class="admin-post-sec">
//     <br>
//             <h1>Wishlist Settings</h1>
//             <br>
//             <h4 style = "width:60%;">Enable a wishlist feature for all post types, allowing users to save and manage their favorite content—whether its products, blog posts, or custom items—creating a personalized and engaging browsing experience.</h4>
//             <br>
//             <form method="POST">
//             <div class="form-group">
//             <label>Enable wishlist for</label>
//             <select id="filter_post_type" name="filter_post_type">
//             ' . wp_kses(
//         $dropdown_val, array(
//             'option' => array(
//                 'value' => true,
//                 'selected' => true
//             )
//         )
//     ) . '
//             </select>
            
//             </div>
//             <br>
//             <div class="form-group">
//             <label>Wishlist Button Name</label>
//             <input id= "wishlist_title" name = "wishlist_title" type = "text" value="' . esc_attr($wishlist_title) . '" placeholder = "Add to Wishlist"/>
//             </div>
//             <br>
//             <div class="form-group">
//             <label>Remove Wishlist Text</label>
//             <input id= "remove_wishlist_title" name = "remove_wishlist_title" type = "text" value="' . esc_attr($remove_wishlist_title) . '" placeholder = "Remove from Wishlist"/>
//             </div>
//             <br>
//             <div class="form-group">
//             <input type="submit" value="Save Option" id="post_submit" name="post_submit">
//             </div>
    
//             </form>
//             </div>';

// }
// Wishlish_func();

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



function Wishlish_func()
{

    
    $wishlist_post_types = get_post_types(
        array('public' => true),
        'names'
    );

    unset($wishlist_post_types['attachment']);
    unset($wishlist_post_types['page']);

    // Remove 'product' if WooCommerce is not active
    if (!class_exists('WooCommerce')) {
        unset($wishlist_post_types['product']);
    }

    if (isset($_POST['post_submit']) && check_admin_referer('we_admin_settings_action', 'we_admin_settings_nonce')) {

        if (!empty($_POST['filter_post_type'])) {
            $filter_post_type = sanitize_text_field(wp_unslash($_POST['filter_post_type']));
            update_option('we_filter_post_name', $filter_post_type, true);
        }
    
        if (!empty($_POST['wishlist_title'])) {
            update_option('wishlist_name', sanitize_text_field(wp_unslash($_POST['wishlist_title'])), true);
        }
    
        if (!empty($_POST['remove_wishlist_title'])) {
            update_option('we_removed_wishlist_label', sanitize_text_field(wp_unslash($_POST['remove_wishlist_title'])), true);
        }
    }
    
    

    $wishlist_post_name = get_option('we_filter_post_name');
    $wishlist_title = get_option('wishlist_name');
    $remove_wishlist_title = get_option('we_removed_wishlist_label');

    unset($wishlist_post_types[$wishlist_post_name]);

    // Initialize the variable to avoid undefined warnings
    $dropdown_val = '';

    // Start building dropdown only if post types are available
    if (!empty($wishlist_post_name)) {
        $dropdown_val .= '<option value="' . esc_attr($wishlist_post_name) . '" selected>' . esc_html($wishlist_post_name) . '</option>';
    }

    if (!empty($wishlist_post_types)) {
        foreach ($wishlist_post_types as $wishlist_post_type) {
            $dropdown_val .= '<option value="' . esc_attr($wishlist_post_type) . '">' . esc_html($wishlist_post_type) . '</option>';
        }
    }

    echo '<div class="admin-post-sec">
    <br>
        <h1>Wishlist Settings</h1>
        <br>
        <h4 style="width:60%;">Enable a wishlist feature for all post types, allowing users to save and manage their favorite content—whether its products, blog posts, or custom items—creating a personalized and engaging browsing experience.</h4>
        <br>
        <form method="POST">';
        wp_nonce_field('we_admin_settings_action', 'we_admin_settings_nonce');
        echo '<div class="form-group">
                <label>Enable wishlist for</label>
                <select id="filter_post_type" name="filter_post_type">
                    ' . wp_kses($dropdown_val, array(
                        'option' => array(
                            'value' => true,
                            'selected' => true
                        )
                    )) . '
                </select>
            </div>
            <br>
            <div class="form-group">
                <label>Wishlist Button Name</label>
                <input id="wishlist_title" name="wishlist_title" type="text" value="' . esc_attr($wishlist_title) . '" placeholder="Add to Wishlist" />
            </div>
            <br>
            <div class="form-group">
                <label>Remove Wishlist Text</label>
                <input id="remove_wishlist_title" name="remove_wishlist_title" type="text" value="' . esc_attr($remove_wishlist_title) . '" placeholder="Remove from Wishlist" />
            </div>
            <br>
            <div class="form-group">
                <input type="submit" value="Save Option" id="post_submit" name="post_submit">
            </div>
        </form>
    </div>';
}
Wishlish_func();
