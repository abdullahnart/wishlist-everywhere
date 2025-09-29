<?php
/**
 * This function is provided for admin area Only.
 * 
 * @category   Class
 * @package    Wishlist_Everywhere_Plugin
 * @subpackage Wishlist_Everywhere_Plugin/admin/partials
 * @author     Abdullah Naseem  <mabdullah.art2023@gmail.com>
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://example.com
 * @since      1.0.0
 */

function render_wishlist_analytics_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cstmwishlist_logs';

    // --- Top Products ---
    $top_products = $wpdb->get_results("
        SELECT post_id, COUNT(*) as total
        FROM {$table_name}
        GROUP BY post_id
        ORDER BY total DESC
        LIMIT 5
    ");

    // $product_labels = [];
    // $product_data   = [];
    // $product_urls   = [];

    // foreach ($top_products as $product) {
    //     $product_labels[] = get_the_title($product->post_id);
    //     $product_data[]   = $product->total;
    //     $product_urls[]   = get_permalink($product->post_id);
    // }

    // --- Top Users ---
    // $top_users = $wpdb->get_results("
    //     SELECT user_id, COUNT(*) as total
    //     FROM {$table_name}
    //     GROUP BY user_id
    //     ORDER BY total DESC
    //     LIMIT 5
    // ");

    // $user_labels = [];
    // $user_data   = [];

    // foreach ($top_users as $user) {
    //     $user_info = get_userdata($user->user_id);
    //     if ($user_info) {
    //         $user_labels[] = $user_info->user_login;
    //         $user_data[]   = $user->total;
    //     }
    // }
    ?>

<div class = "wishlist-analytics-table">
    <h2>Wishlist Analytics</h2>
    <h1>Most Wishlisted Products</h1>
    <div class="wishlisted-products">
    <table>

        <th align = "left">Product Image</th>
        <th>Number of Visits</th>
        <th>View Product</th>
        <?php foreach ($top_products as $product) : 
            $post_type = get_post_type($product->post_id);
            if ($post_type !== 'product') {
                continue; // Skip non-product post types
            }
            
            ?>
            <tr>
                <td class ="first-col"><?php echo get_the_post_thumbnail($product->post_id); ?><span><?php echo get_the_title($product->post_id); ?></span></td>
                <td align = "center"><?php echo $product->total; ?></td>
                <td align = "center"><a class="wishlist-link" target = "_blank" href = "<?php echo get_permalink ($product->post_id); ?>">View</a></td>
        </tr>
        <?php endforeach; ?>

    </table>
    </div>
    <!-- <div class="wrap">
        <canvas id="wishlistProductsChart" width="400" height="200"></canvas>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        // Products Bar Chart
        new Chart(document.getElementById('wishlistProductsChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($product_labels); ?>,
                datasets: [{
                    label: 'Wishlist Count',
                    data: <?php echo json_encode($product_data); ?>,
                    backgroundColor: '#4e79a7'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Top 5 Products' }
                }
            }
        });

        // Users Pie Chart
        new Chart(document.getElementById('wishlistUsersChart'), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($user_labels); ?>,
                datasets: [{
                    label: 'Wishlist Activity',
                    data: <?php echo json_encode($user_data); ?>,
                    backgroundColor: [
                        '#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: { display: true, text: 'Top 5 Users' }
                }
            }
        });
        </script>
    </div> -->
    </div>
    <?php
}

render_wishlist_analytics_page();

