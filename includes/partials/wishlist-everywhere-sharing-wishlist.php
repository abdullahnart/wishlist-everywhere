<?php



function wishlist_everywhere_shared_template() {

    if ( isset($_GET['user_id']) && is_page('wishlist-share') ) {
        // $user_id = absint($_GET['user_id']);
        $user_id = absint($_GET['user_id']);
        wishlist_everywhere_render_user_wishlist($user_id);
        exit;
    }
}
add_shortcode('template_redirect', 'wishlist_everywhere_shared_template');





function wishlist_everywhere_render_user_wishlist($user_id) {
    global $wpdb;
    $table = $wpdb->prefix . 'cstmwishlist';
    
    // Get all post IDs saved in the wishlist
    $ids = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM $table WHERE user_id = %d", $user_id));

    // Filter only product post types
    $product_ids = array_filter($ids, function($post_id) {
        return get_post_type($post_id) === 'product';
    });

    if (!empty($product_ids)) {
        echo '<h2>Shared Wishlist</h2>';
        echo '<table class="wishlist-products">';
        echo '<thead><tr><th>Title</th><th>Price</th><th>View Page</th></tr></thead>';
        echo '<tbody>';

        foreach ($product_ids as $post_id) {
            $title = get_the_title($post_id);
            $price = wc_get_product($post_id)->get_price_html();
            $link = get_permalink($post_id);

            echo '<tr>';
            echo '<td>' . esc_html($title) . '</td>';
            echo '<td>' . $price . '</td>';
            echo '<td><a href="' . esc_url($link) . '" target="_blank">View</a></td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p>No products in wishlist.</p>';
    }
}




