<?php


    add_shortcode('wishlist_everywhere', 'display_wishlist_page');

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
                    <th>View Page</th>
                    <!-- <th>Share</th> -->
                    ';
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

        echo '<tr class="wishlist-item post-' . esc_attr($post->ID) . '">';

        // 🗑 Remove icon
        echo '<td style="text-align:center;">
                <a href="#" class="wishlist-icon-remove" data-post-id="' . esc_attr($post->ID) . '" data-nonce="' . esc_attr($nonce) . '">🗑 ' . esc_html($remove_wishlist_title) . '</a>
              </td>';

        // 🏷 Title
        echo '<td>' . esc_html($post->post_title) . '</td>';

        // 📦 WooCommerce product handling
        if ($post->post_type === 'product' && function_exists('wc_get_product')) {
            $product = wc_get_product($post->ID);
            $out_of_stock_class = !$product->is_in_stock() ? 'out-of-stock' : '';

            if ($product) {
                $price = $product->get_price_html();
                echo '<td><p><strong>Price:</strong> ' . wp_kses_post($price) . '</p></td>';

                // 🛒 Add to Cart Column
                echo '<td class="var_product' . esc_attr($out_of_stock_class) . '">';

                if ($product->is_type('variable') && $product->is_in_stock()) {
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

                    if ($variation_id && $product->is_in_stock()) {
                        $add_to_cart_url = esc_url(add_query_arg($query_args, $product->add_to_cart_url()));
                        $add_to_cart_text = esc_html($product->add_to_cart_text());
                        echo '<a href="' . $add_to_cart_url . '" data-product_id="' . esc_attr($product->get_id()) . '"
                        data-product_sku="' . esc_attr($product->get_sku()) . '" class="button ajax_add_to_cart add-to-cart-btn">' . esc_html($add_to_cart_text) . '</a>';
                    } else {
                        echo '<span class="button disabled">Select Options</span>';
                    }

                } elseif ($product->is_type('simple') && $product->is_purchasable() && $product->is_in_stock()) {
                    $add_to_cart_url  = esc_url($product->add_to_cart_url());
                    $add_to_cart_text = esc_html($product->add_to_cart_text());
                    $product_id       = $product->get_id();
                    echo '<a href="' . $add_to_cart_url . '" data-product_id="' . esc_attr($product_id) . '" class="add-to-cart-btn button add_to_cart_button ajax_add_to_cart">' . $add_to_cart_text . '</a>';
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

        
            echo '<tr>
            <td colspan = 2><a href="#" class="remove-all-wishlist" data-post-id="' . esc_attr($post->ID) . '" data-nonce="' . esc_attr($nonce) . '">🗑 Remove All from wishlist </a></td>
            <td colspan = 3><button id="all-add-to-cart" class="button add-to-cart-btn">Add All to Cart</button></td>
            </tr>
            </tbody></table></div>';
            $first = false;
        }

        echo '</div>'; // .wishlist-wrapper


    }    




add_action('wp_ajax_wishlist_bulk_add_to_cart', 'wishlist_bulk_add_to_cart');
add_action('wp_ajax_nopriv_wishlist_bulk_add_to_cart', 'wishlist_bulk_add_to_cart');

function wishlist_bulk_add_to_cart() {
    if (!isset($_POST['product_ids']) || !is_array($_POST['product_ids'])) {
        wp_send_json_error('Missing or invalid product IDs');
    }

    $product_ids = array_map('intval', $_POST['product_ids']);

    foreach ($product_ids as $product_id) {
        $product = wc_get_product($product_id);

        if (!$product) {
            continue;
        }

        if ($product->is_type('variable') && $product->is_in_stock()) {
            $variations = $product->get_available_variations();
            if (!empty($variations)) {
                $variation = $variations[0]; // Add first available variation
                WC()->cart->add_to_cart($product_id, 1, $variation['variation_id'], $variation['attributes']);
            }
        } else {
            WC()->cart->add_to_cart($product_id);
        }
    }

    wp_send_json_success('All products added to cart');
}

