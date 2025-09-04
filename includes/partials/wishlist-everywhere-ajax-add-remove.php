<?php

add_action('wp_ajax_add_to_wishlist', 'add_to_wishlist_callback');
add_action('wp_ajax_nopriv_add_to_wishlist', 'add_to_wishlist_callback');


function add_to_wishlist_callback()
{

    // ✅ Verify nonce
    check_ajax_referer('wishlist_nonce_action', 'security');

    // ✅ Check user permission
    // if (!is_user_logged_in() || !current_user_can('read')) {
    //     wp_send_json_error('Unauthorized access');
    //     wp_die();
    // }

    global $wpdb;
    $table_name = $wpdb->prefix . 'cstmwishlist';
    $table_name_analytics = $wpdb->prefix . 'cstmwishlist_logs';
    $post_id = isset($_POST['post_id']) ? sanitize_text_field(wp_unslash($_POST['post_id'])) : '';
    
    // Check if the post ID already exists in the wishlist
    // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
    if(is_user_logged_in() && current_user_can('read')){
    $current_user_id = get_current_user_id();
    $existing_item = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM {$table_name} WHERE post_id = %d AND user_id = %d",
            $post_id,
            $current_user_id
        )
    );

    if (!$existing_item) {
        // If the post ID does not exist, insert it into the wishlist table
        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $wpdb->insert(
            $table_name_analytics,
            array(
                'post_id' => $post_id,
                'user_id' => $current_user_id,
                'created_at' => current_time('mysql') // optional timestamp
            ),
            array('%d', '%d', '%s')
        );

        $wpdb->insert(
            $table_name,
            array(
                'post_id' => $post_id,
                'user_id' => $current_user_id
            )
        );
        // Return success response
        wp_send_json_success();
    } else {
        // If the post ID already exists, return an error response
        wp_send_json_error('Post already exists in wishlist');
    }
}else{
    // ✅ Guest user, save in PHP session
    if (!session_id()) {
        session_start();
    }

    if (!isset($_SESSION['guest_wishlist'])) {
        $_SESSION['guest_wishlist'] = [];
    }

    if (in_array($post_id, $_SESSION['guest_wishlist'])) {
        wp_send_json_error('Already in wishlist');
    } else {
        $_SESSION['guest_wishlist'][] = $post_id;
        wp_send_json_success('Added to wishlist');
    }
}

    wp_die();
}

add_action('wp_ajax_remove_from_wishlist', 'remove_from_wishlist_callback');
add_action('wp_ajax_nopriv_remove_from_wishlist', 'remove_from_wishlist_callback');


function remove_from_wishlist_callback()
{

    // ✅ Verify nonce
check_ajax_referer('wishlist_nonce_action', 'security');
$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
if (!$post_id) {
    wp_send_json_error('Invalid product');
}

    // ✅ Check user permission
    // if (!is_user_logged_in() || !current_user_can('read')) {
    //     wp_send_json_error('Unauthorized access');
    //     wp_die();
    // }

if (is_user_logged_in() && current_user_can('read')) {
    // Logged-in user: remove from database
    global $wpdb;
    $table_name = $wpdb->prefix . 'cstmwishlist';

    $wpdb->delete(
        $table_name,
        array(
            'post_id' => $post_id,
            'user_id' => get_current_user_id()
        )
    );
    // Return success response
    wp_send_json_success(['message' => 'Item removed', 'post_id' => $post_id]);

}
else{
    if(!session_id()){
        session_start();
    }
    
    if(!empty($_SESSION['guest_wishlist'])){
        $_SESSION['guest_wishlist'] = array_filter(
            $_SESSION['guest_wishlist'],
            function ($id) use ($post_id){
                return intval($id) !== $post_id;
            }
        );
    }
    wp_send_json_success('Removed from wishlist');
}
    wp_die();
}