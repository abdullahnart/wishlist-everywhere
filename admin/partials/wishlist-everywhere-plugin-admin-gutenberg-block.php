<?php

function wishlist_register_gutenberg_block() {
    // Register block script (only needed if you want a custom editor script)
    wp_register_script(
        'wishlist-block-js',
        plugins_url('../js/wishlist-everywhere-block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-block-editor'),
        filemtime(plugin_dir_path(__FILE__) . '../js/wishlist-everywhere-block.js')
    );

    register_block_type('wishlist-everywhere/wishlist-block', array(
        'editor_script'   => 'wishlist-block-js',
        'render_callback' => 'wishlist_render_wishlist_block',
    ));

    register_block_type('wishlist-everywhere/wishlist-counter', array(
        'editor_script'   => 'wishlist-block-js',
        'render_callback' => 'wishlist_render_gutenberg_counter_block',
    ));
}
$check_enable_gutenberg = get_option('enable_wishlist_gutenberg');
if ($check_enable_gutenberg === 'enable_wishlist_gutenberg'){
    add_action('init', 'wishlist_register_gutenberg_block');
}



function wishlist_render_wishlist_block($attributes){
    ob_start();
    echo '<div class="wishlist-block-wrapper">';
    echo do_shortcode('[wishlist_everywhere]'); // your existing wishlist function
    echo '</div>';
    return ob_get_clean();
}


function wishlist_render_gutenberg_counter_block($attributes){
    ob_start();
    echo '<div class="wishlist-counter-block-wrapper">';
    echo do_shortcode('[wishlist_everywhere_counter]'); // your existing wishlist counter function
    echo '</div>';
    return ob_get_clean();
}

?>