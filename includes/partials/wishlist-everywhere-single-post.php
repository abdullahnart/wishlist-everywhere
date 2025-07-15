<?php
    add_filter('the_content', 'add_wishlist_icon_to_posts', 10, 1);


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