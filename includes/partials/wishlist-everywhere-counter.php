<?php

function wishev_display_wishlist_counter() {

    if ( ! function_exists('is_user_logged_in') ) {
        return;
    }

    $required_login   = get_option('required_login');
    $counter_position = get_option('wishlist_counter_position');

    if ($required_login == false && is_user_logged_in()) {

        global $wpdb;
        $table_name = $wpdb->prefix . 'cstmwishlist';
        $current_user_id = get_current_user_id();

        $count = (int) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM {$table_name} WHERE user_id = %d",
                $current_user_id
            )
        );

    } else {
        $count = 0;
    }

    $counter_color = get_option('counter_color');

    echo '<div class="wishlist-counter' . esc_attr($counter_position) . '" style="color: ' . esc_attr($counter_color) . '">';
    if ($count == 0) {
        echo '<i class="far fa-heart"></i> ';
    } else {
        echo '<i class="fas fa-heart fa-solid"></i> ';
    }
    echo '<span class="wishlist-count">' . esc_html($count) . '</span>';
    echo '</div>';
}

// ✅ Add to header menu instead of footer
add_filter('wp_nav_menu_items', 'wishev_add_counter_to_menu', 10, 2);

function wishev_add_counter_to_menu($items, $args) {


        $enable_we_counter = get_option('wish_for_count');
        $wishlist_menu_id = get_option('wishlist_menu_id');
        if ( !$enable_we_counter ) {
            return $items;
        }

        if ( $args->menu->term_id != $wishlist_menu_id ) {
            return $items;
        }

    if ( is_admin() || wp_doing_ajax() ) {
        return $items;
    }

    ob_start();
    wishev_display_wishlist_counter();
    $counter_html = ob_get_clean();

    return $items . '<li class="menu-item wishlist-menu-item">' . $counter_html . '</li>';
}
add_shortcode('wishlist_everywhere_counter', 'wishev_display_wishlist_counter');