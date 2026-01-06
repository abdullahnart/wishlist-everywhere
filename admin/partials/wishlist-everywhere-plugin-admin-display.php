<?php
/**
 * This function is provided for admin area only and dropdown.
 * 
 * @category   Partial Admin
 * @package    Wishlist_Everywhere_Plugin
 * @subpackage Wishlist_Everywhere_Plugin/admin/partials
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 * 
 * @return String
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// function wishev_render_button()
// {

    
    $wishlist_post_types = get_post_types(
        array('public' => true),
        'objects'
    );
    $wishlist_archive_positions = [
        'before' => 'Before "Add to cart" Button',
        'above_thumbnail' => 'Above Thumbnail',
        'custom_position' => 'Custom Position',
    ];

    $wishlist_single_positions = [
        'before' => 'Before "Add to cart" Button',
        'after' => 'After "Add to cart" Button',
        'custom_position' => 'Custom Position',
    ];

    $wishlist_icons = [
        'icon_only' => 'Icon Only',
        'text_only' => 'Text Only',
        'icon_text' => 'Text + Icon',
    ];


    unset($wishlist_post_types['attachment']);
    unset($wishlist_post_types['page']);
      foreach ($wishlist_post_types as $key => $obj) {
         if (
            stripos($key, 'elementor') !== false ||
            stripos($key, 'buttons') !== false ||
            stripos($key, 'templates') !== false ||
            stripos($key, 'form') !== false ||
            stripos($key, 'menu') !== false
         ) {
            unset($wishlist_post_types[$key]);
         }
      }


    // var_dump(get_option('wishlist_archive_position'));

    // Remove 'product' if WooCommerce is not active
    if (!class_exists('WooCommerce')) {
        unset($wishlist_post_types['product']);
    }

    if (isset($_POST['post_submit']) && check_admin_referer('we_admin_settings_action', 'we_admin_settings_nonce')) {

        if (!empty($_POST['filter_post_type'])) {
            $filter_post_type = sanitize_text_field(wp_unslash($_POST['filter_post_type']));
            update_option('wishev_filter_post_name', $filter_post_type, true);
        }

        if (!empty($_POST['archive_option'])) {
            $archive_option = sanitize_text_field(wp_unslash($_POST['archive_option']));
            update_option('wishlist_archive_position', $archive_option, true);
        }

        if (!empty($_POST['single_option'])) {
            $single_option = sanitize_text_field(wp_unslash($_POST['single_option']));
            update_option('wishlist_single_position', $single_option, true);
        }        
    
        if (!empty($_POST['wishlist_custom_icon'])) {
            $wishlist_custom_icon = sanitize_text_field(wp_unslash($_POST['wishlist_custom_icon']));
            update_option('wishlist_custom_icon', $wishlist_custom_icon, true);
        }

        if (isset($_POST['wishlist_archive']) && $_POST['wishlist_archive'] === 'archive') {
            update_option('wishlist_for_archive', 'archive');
        } else {
            delete_option('wishlist_for_archive');
        }

        if (isset($_POST['wishlist_for_login']) && $_POST['wishlist_for_login'] === 'required_login') {
            update_option('required_login', 'required_login');
        } else {
            delete_option('required_login');
        }

        if (isset($_POST['enable_wish_account']) && $_POST['enable_wish_account'] === 'enable_wishlist_myaccount') {
            update_option('enable_wishlist_myaccount', 'enable_wishlist_myaccount');
        } else {
            delete_option('enable_wishlist_myaccount');
        }

        if (isset($_POST['enable_wish_gutenberg']) && $_POST['enable_wish_gutenberg'] === 'enable_wishlist_gutenberg') {
            update_option('enable_wishlist_gutenberg', 'enable_wishlist_gutenberg');
        } else {
            delete_option('enable_wishlist_gutenberg');
        }
        

         if (isset($_POST['wishlist_post_placement']) && $_POST['wishlist_post_placement'] === 'enable_post_placement') {
            update_option('enable_post_placement', 'enable_post_placement');
        } else {
            delete_option('enable_post_placement');
        }

        if (isset($_POST['wishlist_custom_css'])){
            update_option('wishlist_custom_css', wp_kses_post($_POST['wishlist_custom_css']));
        }

        if (isset($_POST['button_font_size'])){
            update_option('button_font_size', wp_kses_post($_POST['button_font_size']));
        }
        if (isset($_POST['button_bg_color'])){
            update_option('button_bg_color', wp_kses_post($_POST['button_bg_color']));
        }
         if (isset($_POST['button_bg_color_2'])){
            update_option('button_bg_color_2', wp_kses_post($_POST['button_bg_color_2']));
        }
         if (isset($_POST['remove_bg_color'])){
            update_option('remove_bg_color', wp_kses_post($_POST['remove_bg_color']));
        }
         if (isset($_POST['icon_color'])){
            update_option('icon_color', wp_kses_post($_POST['icon_color']));
        }

         // Facebook
         if (isset($_POST['share_facebook']) && $_POST['share_facebook'] === 'yes') {
            update_option('enable_facebook', 'yes');
         } else {
            delete_option('enable_facebook');
         }

         // WhatsApp
         if (isset($_POST['share_whatsapp']) && $_POST['share_whatsapp'] === 'yes') {
            update_option('enable_whatsapp', 'yes');
         } else {
            delete_option('enable_whatsapp');
         }

         // Twitter
         if (isset($_POST['share_twitter']) && $_POST['share_twitter'] === 'yes') {
            update_option('enable_twitter', 'yes');
         } else {
            delete_option('enable_twitter');
         }

         // Pinterest
         if (isset($_POST['share_pinterest']) && $_POST['share_pinterest'] === 'yes') {
            update_option('enable_pinterest', 'yes');
         } else {
            delete_option('enable_pinterest');
         }

         // Copy to Clipboard
         if (isset($_POST['copy_clipboard']) && $_POST['copy_clipboard'] === 'yes') {
            update_option('enable_clipboard', 'yes');
         } else {
            delete_option('enable_clipboard');
         }

        
        if (isset($_POST['wishlist_single']) && $_POST['wishlist_single'] === 'single') {
            update_option('wishlist_for_single', 'single');
        } else {
            delete_option('wishlist_for_single');
        }

        if (isset($_POST['enable_css']) && $_POST['enable_css'] === 'custom_css') {
            update_option('enable_custom_css', 'custom_css');
        } else {
            delete_option('enable_custom_css');
        }

        if (!empty($_POST['wishlist_title'])) {
            update_option('wishlist_name', sanitize_text_field(wp_unslash($_POST['wishlist_title'])), true);
        }

        if (!empty($_POST['remove_wishlist_title'])) {
            update_option('wishev_removed_wishlist_label', sanitize_text_field(wp_unslash($_POST['remove_wishlist_title'])), true);
        }
    }
    
    

    $wishlist_post_name = get_option('wishev_filter_post_name');
    $wishlist_title = get_option('wishlist_name');
    $remove_wishlist_title = get_option('wishev_removed_wishlist_label');
    $wishlist_position = get_option('wishlist_archive_position');
    $wishlist_single_position = get_option('wishlist_single_position');
    $wishlist_icon_option = get_option('wishlist_custom_icon');

    unset($wishlist_post_types[$wishlist_post_name]);

    // Initialize the variable to avoid undefined warnings
    $dropdown_val = '';
    $archive_position_val = '';
    $single_position_val = '';
    $wishlist_custom_icon = '';

    // Start building dropdown only if post types are available
    if (!empty($wishlist_post_name)) {
        $dropdown_val .= '<option value="' . esc_attr($wishlist_post_name) . '" selected>' . esc_html($wishlist_post_name) . '</option>';
    }

   if (!empty($wishlist_post_types)) {
      foreach ($wishlist_post_types as $post_type_key => $post_type_obj) {
         $dropdown_val .= '<option value="' . esc_attr($post_type_key) . '">'
               . esc_html($post_type_obj->labels->singular_name)
               . '</option>';
      }
   }
    // if (!empty($wishlist_position)) {
    //     $archive_position_val .= '<option value="' . esc_attr($wishlist_position) . '" selected>' . esc_html($wishlist_position) . '</option>';
    // }    
    if (!empty($wishlist_archive_positions)) {
        foreach ($wishlist_archive_positions as $value => $label) {
            $archive_position_val .= sprintf(
                '<option value="%s"%s>%s</option>',
                esc_attr($value),
                selected($wishlist_position, $value, false),
                esc_html($label)
            );
        }
    }


    if (!empty($wishlist_single_positions)) {
        foreach ($wishlist_single_positions as $value => $label) {
            $single_position_val .= sprintf(
                '<option value="%s"%s>%s</option>',
                esc_attr($value),
                selected($wishlist_single_position, $value, false),
                esc_html($label)
            );
        }
    }


    if (!empty($wishlist_icons)) {
        foreach ($wishlist_icons as $value => $label) {
            $wishlist_custom_icon .= sprintf(
                '<option value="%s"%s>%s</option>',
                esc_attr($value),
                selected($wishlist_icon_option, $value, false),
                esc_html($label)
            );
        }
    }    

 echo '
<div class="admin-post-sec">
   <br>
   <h1>Wishlist Settings</h1>
   <br>
   <h4 style="width:60%;">Enable a wishlist feature for all post types, allowing users to save and manage their favorite content—whether its products, blog posts, or custom items—creating a personalized and engaging browsing experience.</h4>
   <br>
   <form method="POST">
      ';
      wp_nonce_field('we_admin_settings_action', 'we_admin_settings_nonce');
      echo '
      <div class = "row_wrapper">
      <div class = "group-wrapper">
        <h2>General Settings</h2>
         <div class="form-group">
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
         <div class="form-group login-tab">
            <label>Require Login</label>
            <div id="container" class="gd">
               <div class="toggle-button-container">
                  <div class="toggle-button gd">
                     <div class="btn btn-rect" id="button-10">
                        <input type="checkbox" class="checkbox" id="wishlist_for_login" name="wishlist_for_login" value="required_login"' . checked(get_option('required_login'), 'required_login', false) . ' />
                        <div class="knob">
                           <span>NO</span>
                        </div>
                        <div class="btn-bg"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group account-tab">
            <label>Enable Wishlist Tab in My Account</label>
            <div id="container" class="gd">
               <div class="toggle-button-container">
                  <div class="toggle-button gd">
                     <div class="btn btn-rect" id="button-10">
                        <input type="checkbox" class="checkbox" id="enable_wish_account" name="enable_wish_account" value="enable_wishlist_myaccount"' . checked(get_option('enable_wishlist_myaccount'), 'enable_wishlist_myaccount', false) . ' />
                        <div class="knob">
                           <span>NO</span>
                        </div>
                        <div class="btn-bg"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div> 
         <div class="form-group placement-tab">
            <label>Custom Wishlist Placement (shortcode)</label>
            <div id="container" class="gd">
               <div class="toggle-button-container">
                  <div class="toggle-button gd">
                     <div class="btn btn-rect" id="button-10">
                        <input type="checkbox" class="checkbox" id="wishlist_post_placement" name="wishlist_post_placement" value="enable_post_placement"' . checked(get_option('enable_post_placement'), 'enable_post_placement', false) . ' />
                        <div class="knob">
                           <span>NO</span>
                        </div>
                        <div class="btn-bg"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group">
            <label>Enable Wishlist Block in Gutenberg</label>
            <div id="container" class="gd">
               <div class="toggle-button-container">
                  <div class="toggle-button gd">
                     <div class="btn btn-rect" id="button-10">
                        <input type="checkbox" class="checkbox" id="enable_wish_gutenberg" name="enable_wish_gutenberg" value="enable_wishlist_gutenberg"' . checked(get_option('enable_wishlist_gutenberg'), 'enable_wishlist_gutenberg', false) . ' />
                        <div class="knob">
                           <span>NO</span>
                        </div>
                        <div class="btn-bg"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>                                      
      </div>
      <div class = "detail-wrapper">
  <ol>
    <li>
      <strong>Enable Wishlist For</strong>: Choose the post type (such as Products, Posts, or Custom post type) where the wishlist feature should be available.
    </li>
    <li>
      <strong>Require Login</strong>: Enable this option to restrict wishlist usage to logged-in users only.
    </li>
    <li>
      <strong>Wishlist Tab in My Account</strong>: Adds a dedicated “Wishlist” tab to the WooCommerce <strong>My Account</strong> section for easy access.
    </li>
    <li>
      <strong>Gutenberg Block Support</strong>: Allows you to add wishlist functionality directly within the Gutenberg editor using a dedicated block.
    </li>
      <li><strong>Custom Wishlist Placement (shortcode):</strong> Enable this option to use this shortcode <code>[wishlist_post]</code> for placing the wishlist button anywhere manually within your site’s content or templates.</li>

  </ol>


      </div>
      </div>
      <div class = "row_wrapper wishev_position" style = "display:none;">
      <div class = "group-wrapper" >
         <h2>Product Listing Button Settings</h2>
         <div class="form-group">
            <label>Enable Wishlist on Product Listing Page</label>
            <div id="container" class="gd">
               <div class="toggle-button-container">
                  <div class="toggle-button gd">
                     <div class="btn btn-rect" id="button-10">
                        <input type="checkbox" class="checkbox" id="wishlist_archive" name="wishlist_archive" value="archive"' . checked(get_option('wishlist_for_archive'), 'archive', false) . ' />
                        <div class="knob">
                           <span>NO</span>
                        </div>
                        <div class="btn-bg"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group for_archive">
            <label>Wishlist Button Position</label>
            <select id="archive_option" name="archive_option">
                ' . $archive_position_val . '
            </select>
         </div>
      </div>
      <div class = "detail-wrapper">
         <ol>
  <li>
    <strong>Enable Wishlist on Product Listing Page</strong><br>
  </li>
  <li>
    <strong>Wishlist Button Position</strong><br>
    Choose where the button appears in the product card:
    <ol>
      <li><strong>Before "Add to Cart"</strong> – Above the cart button.</li>
      <li><strong>Above Thumbnail</strong> – Over the product image.</li>
      <li><strong>Custom Position</strong> – Use this shortcode <code>[wishlist_everywhere_archive]</code> or PHP for manual placement.</li>
    </ol>
    Easily control how the wishlist appears in product listings.
  </li>
</ol>

      </div>
      </div>
      <div class = "row_wrapper wishev_position" style = "display:none;">
      <div class = "group-wrapper">
         <h2>Product Page Button Settings</h2>
         <div class="form-group">
            <label>Enable Wishlist on Product Page</label>
            <div id="container" class="gd">
               <div class="toggle-button-container">
                  <div class="toggle-button gd">
                     <div class="btn btn-rect" id="button-10">
                        <input type="checkbox" class="checkbox" id="wishlist_single" name="wishlist_single" value="single"' . checked(get_option('wishlist_for_single'), 'single', false) . ' />
                        <div class="knob">
                           <span>NO</span>
                        </div>
                        <div class="btn-bg"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group for_single">
            <label>Wishlist Button Position</label>
            <select id="single_option" name="single_option">
                ' . $single_position_val . '
            </select>
         </div>
      </div>
      <div class = "detail-wrapper">
         <ol>
         <li>
            <strong>Enable Wishlist on Product Page</strong><br>
            Show the wishlist button on individual product pages so customers can save items while viewing product details.
         </li>
         <li>
            <strong>Wishlist Button Position</strong><br>
            Choose where to place the wishlist button:
            <ol>
               <li><strong>Before "Add to Cart"</strong> – Display above the add-to-cart button.</li>
               <li><strong>After "Add to Cart"</strong> – Display below the add-to-cart button.</li>
               <li><strong>Custom Position</strong> – Use this <code>[wishlist_everywhere_single]</code> shortcode or PHP function for manual placement.</li>
            </ol>
         </li>
         </ol>
      </div>      
      </div>
      <div class = "row_wrapper">      
      <div class = "group-wrapper">
        <h2>Wishlist Button Settings</h2>
         <div class="form-group">
            <label>Display Style</label>
            <select id="wishlist_custom_icon" name="wishlist_custom_icon">
                ' . $wishlist_custom_icon . '
            </select>         
            </div>        
         <div class="form-group">
            <label>Wishlist Button Label</label>
            <input id="wishlist_title" name="wishlist_title" type="text" value="' . esc_attr($wishlist_title) . '" placeholder="Add to Wishlist" />
         </div>
         <div class="form-group">
            <label>Remove from Wishlist Text</label>
            <input id="remove_wishlist_title" name="remove_wishlist_title" type="text" value="' . esc_attr($remove_wishlist_title) . '" placeholder="Remove from Wishlist" />
         </div>
      </div>
      <div class = "detail-wrapper">
         <ol>
         <li>
         <strong>Display Style</strong><br>
         Choose how the wishlist button appears on products: icon only, text only, or both.
         </li>
         <li>
            <strong>Wishlist Button Label</strong><br>
            Set the text shown when a user adds a product to their wishlist (e.g., “Add to Favorites”).
         </li>
         <li>
            <strong>Remove from Wishlist Text</strong><br>
            Set the text shown when a product is already in the wishlist and the user can remove it.
         </li>
         </ol>
      </div>      
      </div>
      <div class = "row_wrapper" style = "display:none;">
      <div class = "group-wrapper">
        <h2>Styling Options</h2>
         <div class="form-group">
            <label>Enable CSS</label>
            <div id="container" class="gd">
               <div class="toggle-button-container">
                  <div class="toggle-button gd">
                     <div class="btn btn-rect" id="button-10">
                        <input type="checkbox" class="checkbox" id="enable_css" name="enable_css" value="custom_css"' . checked(get_option('enable_custom_css'), 'custom_css', false) . ' />
                        <div class="knob">
                           <span>NO</span>
                        </div>
                        <div class="btn-bg"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class = "detail-wrapper">
         <ol>
         <li>
            <strong>Theme Settings</strong><br>
            Customize colors, fonts, and layout options to match your store’s style.
         </li>
         <li>
            <strong>Advanced Options</strong><br>
            Add custom CSS, or animations for more control over design and behavior.
         </li>
         </ol>
      </div>
      </div>
      <div class = "row_wrapper">
      <div class = "group-wrapper">
         <h2>Styling Options</h2>
         <div class = "custom-styling">
            <div class = "form-group title-size">
               <label>Button Font Size (px)</label>
               <input type="number" id="button_font_size" name="button_font_size" value="' . esc_attr(get_option('button_font_size',18)) . '" min="10">
            </div>
            <div class = "form-group btn-bg-color">
               <label>Add Button Background Color 1</label>
               <input type="color" id="button_bg_color" name="button_bg_color" value="' . esc_attr(get_option('button_bg_color')) . '">
            </div>
            <div class = "form-group btn-bg-color">
               <label>Add Button Background Color 2</label>
               <input type="color" id="button_bg_color_2" name="button_bg_color_2" value="' . esc_attr(get_option('button_bg_color_2')) . '">
            </div>';
            // echo'
            // <div class = "form-group rmv-bg-color">
            //    <label>Remove Button Background Color</label>
            //    <input type="color" id="remove_bg_color" name="remove_bg_color" value="' . esc_attr(get_option('remove_bg_color')) . '">
            // </div>';
            echo'
            <div class = "form-group icon-color">
               <label>Text Color</label>
               <input type="color" id="icon_color" name="icon_color" value="' . esc_attr(get_option('icon_color')) . '">
            </div>             
         </div>
      </div>
      <div class = "detail-wrapper">
         <ol>
         <li><strong>Button Font Size</strong><br>
               Adjust the size of the button text. Default is <em>18px</em>, but you can change it to match your store’s style.
         </li>
         <li><strong>Background Colors</strong><br>
               Define the gradient for your button background:
               <ul>
               <li><strong>Background Color 1</strong>: The top color of the gradient.</li>
               <li><strong>Background Color 2</strong>: The bottom color of the gradient.</li>
               </ul>
         </li>
         <li><strong>Text Color</strong><br>
               Choose the button text color to ensure good contrast and readability.
         </li>
         </ol>

      </div>
      </div>      
      <div class="row_wrapper">
         <div class = "group-wrapper">
            <h2>Entire Wishlist Sharing Options</h2>      
            <div class="form-group">
               <label>Enable "Facebook" Sharing</label>
               <div id="container" class="gd">
                  <div class="toggle-button-container">
                     <div class="toggle-button gd">
                        <div class="btn btn-rect" id="button-10">
                           <input type="checkbox" class="checkbox" id="share_facebook" name="share_facebook" value="yes"' . checked(get_option('enable_facebook'), 'yes', false) . ' />
                           <div class="knob">
                              <span>NO</span>
                           </div>
                           <div class="btn-bg"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label>Enable WhatsApp Sharing</label>
               <div id="container" class="gd">
                  <div class="toggle-button-container">
                     <div class="toggle-button gd">
                        <div class="btn btn-rect" id="button-10">
                           <input type="checkbox" class="checkbox" id="share_whatsapp" name="share_whatsapp" value="yes"' . checked(get_option('enable_whatsapp'), 'yes', false) . ' />
                           <div class="knob">
                              <span>NO</span>
                           </div>
                           <div class="btn-bg"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label>Enable Twitter Sharing	</label>
               <div id="container" class="gd">
                  <div class="toggle-button-container">
                     <div class="toggle-button gd">
                        <div class="btn btn-rect" id="button-10">
                           <input type="checkbox" class="checkbox" id="share_twitter" name="share_twitter" value="yes"' . checked(get_option('enable_twitter'), 'yes', false) . ' />
                           <div class="knob">
                              <span>NO</span>
                           </div>
                           <div class="btn-bg"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label>Enable Pinterest Sharing	</label>
               <div id="container" class="gd">
                  <div class="toggle-button-container">
                     <div class="toggle-button gd">
                        <div class="btn btn-rect" id="button-10">
                           <input type="checkbox" class="checkbox" id="share_pinterest" name="share_pinterest" value="yes"' . checked(get_option('enable_pinterest'), 'yes', false) . ' />
                           <div class="knob">
                              <span>NO</span>
                           </div>
                           <div class="btn-bg"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label>Copy to clipboard</label>
               <div id="container" class="gd">
                  <div class="toggle-button-container">
                     <div class="toggle-button gd">
                        <div class="btn btn-rect" id="button-10">
                           <input type="checkbox" class="checkbox" id="copy_clipboard" name="copy_clipboard" value="yes"' . checked(get_option('enable_clipboard'), 'yes', false) . ' />
                           <div class="knob">
                              <span>NO</span>
                           </div>
                           <div class="btn-bg"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>                                                
         </div>
      <div class="detail-wrapper">
<ol>
<li>
  <strong>Entire Wishlist Sharing Options</strong><br>
  A dedicated Wishlist Share Page is created automatically. You can also use the shortcode <code>[wishlist_share]</code> to display the full wishlist items anywhere on your site.
  It’s a <b>page-level</b> share, not single-post share. This shortcode inserts the <b>entire wishlist</b>, not an individual item.


  </li>



  
  <li><strong>Platform Integration</strong><br>
  <ol>
    <li>Facebook (OG tags)</li>
    <li>WhatsApp (default message)</li>
    <li>Twitter (hashtags)</li>
    <li>Pinterest (image pinning)</li>
    <li>Copy link functionality</li>
  </ul></li>
</ol>
      </div>         
      </div>
      <div class="form-group">
         <input type="submit" value="Save Option" id="post_submit" name="post_submit">
      </div>
      <div class="fixed">
         <button type="submit" id="post_submit" name="post_submit"><i class="fa-regular fa-floppy-disk"></i> Save</button>
      </div>
   </form>
</div>
';
// }
// wishev_render_button();
