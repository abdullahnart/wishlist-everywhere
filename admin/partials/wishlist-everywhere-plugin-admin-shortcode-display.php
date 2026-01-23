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
echo "
<div class='wishev-access-wrapper'>

    <h1 class='wishev-title'>💖 Wishlist Access</h1>
    <p class='wishev-subtitle'>
        Your customers can view and manage their wishlist in multiple flexible ways:
    </p>

    <div class='wishev-cards'>

        <!-- Card 1 -->

        <div class='wishev-card green-card'>
            <div class='card-header green-bg'>
                <h3>🧩 Use Anywhere with Shortcode</h3>
            </div>
            <div class='card-body'>
            <p>Add this shortcode on any page, post, or template:</p>
            <div class='wishev-code'><span class = 'copy_code'>[wishlist_everywhere]</span> </div>

            <p class='wishev-filter-title'>Filter wishlist by content type:</p>

            <p>Only WooCommerce products:</p>
            <div class='wishev-code'><span class = 'copy_code'>[wishlist_everywhere post_type=\"product\"]</span> </div>

            <p>Only blog posts:</p>
            <div class='wishev-code'><span class = 'copy_code'>[wishlist_everywhere post_type=\"post\"]</span> </div>

            <p>Only a specific custom post type:</p>
            <div class='wishev-code'><span class = 'copy_code'>[wishlist_everywhere post_type=\"event\"]</span> </div>

            <p>Multiple types together:</p>
            <div class='wishev-code'><span class = 'copy_code'>[wishlist_everywhere post_type=\"product,post\"]</span> </div>
            </div>
        </div>

        <!-- Card 2 -->

        <div class='wishev-card purple-card'>
            <div class='card-header purple-bg'>
                <h3>📄 Default Wishlist Page</h3>
            </div>
            <div class='card-body'>
                <p>
                    Automatically created page where users can view their complete wishlist.
                </p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class='wishev-card brown-card'>
            <div class='card-header brown-bg'>
                <h3>🧱 Gutenberg Block</h3>
            </div>
            <div class='card-body'>
            <p>
                Add the <strong>Wishlist Everywhere</strong> block in any page using the Block Editor (Gutenberg)
                and visually control how the wishlist is displayed.
            </p>
            </div>
        </div>

    </div>
</div>
";



