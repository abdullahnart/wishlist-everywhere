<?php

    add_action('init','register_wishlist_endpoint');
    $enable_wishlist_myaccount = get_option('enable_wishlist_myaccount');
    if($enable_wishlist_myaccount === 'enable_wishlist_myaccount'){
        add_filter('woocommerce_account_menu_items','add_wishlist_tab_to_my_account');
        add_action('woocommerce_account_wishlist-everywhere_endpoint','show_wishlist_tab_content');
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

function show_wishlist_tab_content(){
    echo do_shortcode('[wishlist_everywhere post_type = "product"]');
}