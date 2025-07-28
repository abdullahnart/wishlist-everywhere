<?php

function wishlist_everywhere_get_sharable_url($user_id){
    return home_url('/wishlist-share/?user_id=' . $user_id);
}

function wishlist_everywhere_shared_template() {
    error_log('Page: ' . get_queried_object()->post_name); // Log current page
    error_log('User ID: ' . ($_GET['user_id'] ?? 'not set'));

    if ( isset($_GET['user_id']) && is_page('wishlist-share') ) {
        // $user_id = absint($_GET['user_id']);
        $user_id = absint($_GET['user_id']);
        wishlist_everywhere_render_user_wishlist($user_id);
        exit;
    }
}
add_action('template_redirect', 'wishlist_everywhere_shared_template');





function wishlist_everywhere_render_user_wishlist($user_id) {
    global $wpdb;
    $table = $wpdb->prefix . 'cstmwishlist';
    $ids = $wpdb->get_col( $wpdb->prepare("SELECT post_id FROM $table WHERE user_id = %d", $user_id) );

    echo '<h2>Shared Wishlist</h2>';
    echo '<ul class="wishlist-products">';
    foreach ($ids as $post_id) {
        echo '<li>' . get_the_title($post_id) . '</li>'; // Or use get_template_part for full product cards
    }
    echo '</ul>';
}


add_action('wp', 'check_user_id');

function check_user_id() {
$user_id = get_current_user_id();
$share_url = wishlist_everywhere_get_sharable_url($user_id);
?>
<div class="wishlist-share-buttons">
    <input type="text" value="<?php echo esc_url($share_url); ?>" readonly onclick="this.select();" />
    
    <a href="https://api.whatsapp.com/send?text=Check+out+my+wishlist:+<?php echo urlencode($share_url); ?>" target="_blank">Share on WhatsApp</a>

    <a href="mailto:?subject=My Wishlist&body=Check out my wishlist: <?php echo esc_url($share_url); ?>">Email</a>

    <button onclick="navigator.clipboard.writeText('<?php echo esc_url($share_url); ?>')">Copy Link</button>
</div>
<?php
}

