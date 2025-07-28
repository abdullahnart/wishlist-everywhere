<?php

    $wishlist_single_position = get_option('wishlist_single_position');
    
    if($wishlist_single_position == 'before') {
        add_action('woocommerce_before_add_to_cart_button', 'add_wishlist_icon_to_product_single', 10, 1);
    }elseif($wishlist_single_position == 'after'){
        add_action('woocommerce_after_add_to_cart_form', 'add_wishlist_icon_to_product_single', 10, 1);
    }else{
        add_shortcode('wishlist_everywhere_single', 'add_wishlist_icon_to_product_single');
    }


    function add_wishlist_icon_to_product_single($content)
    {
        $all_post_name = get_option('wishev_filter_post_name');
        $wishlist_title = get_option('wishlist_name');
        $wishlist_postion = get_option('wishlist_for_single');
        $required_login     = get_option('required_login');
        $post = get_queried_object();
        $wishlist_single_position = get_option('wishlist_single_position');
        $wishlist_icon_option = get_option('wishlist_custom_icon');
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

                if($wishlist_icon_option === 'text_only'){
                    $wishlist_icon = '
                        <a href="#" class="wishlist-icon single" data-post-id="' . esc_attr(get_the_ID()) . '">' . esc_html($wishlist_title) . '</a>
                    ';
                        $content = $wishlist_icon . $content;
                        echo wp_kses_post($content);
                }else if($wishlist_icon_option === 'icon_only'){
                    $wishlist_icon = '
                        <a href="#" class="wishlist-icon icon-only" data-post-id="' . esc_attr(get_the_ID()) . '"><i class="fa-regular fa-heart"></i></a>
                    ';
                        $content = $wishlist_icon . $content;
                        echo wp_kses_post($content);
                }else{
                    $wishlist_icon = '
                        <a href="#" class="wishlist-icon single" data-post-id="' . esc_attr(get_the_ID()) . '"> <i class="fa-regular fa-heart"></i>' . esc_html($wishlist_title) . '</a>
                    ';
                        $content = $wishlist_icon . $content;
                        echo wp_kses_post($content);
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

            $wishlist_icon = '<a href="#" class="wishlist-icon" data-post-id="' . esc_attr(get_the_ID()) . '">' . $wishlist_title . '</a>';
            $content = $wishlist_icon . $content;
            echo wp_kses_post($content);
        }                                 
                     

    }