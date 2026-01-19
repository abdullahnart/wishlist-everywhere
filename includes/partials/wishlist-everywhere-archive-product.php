<?php
        $wishlist_position = get_option('wishlist_archive_position');
        if($wishlist_position == 'above_thumbnail') {
        add_action('woocommerce_before_shop_loop_item', 'add_wishlist_icon_to_product_archive', 10, 1);
        }else if ($wishlist_position == 'before'){
        add_action('woocommerce_after_shop_loop_item', 'add_wishlist_icon_to_product_archive', 10, 1);
        }else{
            add_shortcode('wishlist_everywhere_archive', 'add_wishlist_icon_to_product_archive');
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
    if ($required_login == false) {
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