=== Wishlist Everywhere ===
Contributors: abdullahart
Tags: wishlist, post types, custom post types, WooCommerce
Requires at least: 5.0
Tested up to: 6.8
Stable tag: 1.1.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Short Description: A plugin that adds a wishlist feature for your website, allowing users to save and manage their favorite items.


== Description ==

Wishlist Everywhere adds a flexible and easy-to-use wishlist system to your WordPress website. Let users save products, posts, or any custom content types to a personal wishlist. Works for both logged-in and guest users. Perfect for WooCommerce stores, blogs, event sites, real estate platforms, and more.
Admins can now track **Most Wishlisted Products** and **Top Users by Wishlist Activity** with built-in Analytics.  

=== 🌟 Key Features ===

✅ **Support for Any Post Type**  
Enable wishlist functionality for Products, Posts, Pages, or any Custom Post Type.

✅ **WooCommerce Integration**  
Display wishlist buttons on product listing and product detail pages with full support for WooCommerce hooks.

✅ **Works for Both Logged-in and Guest Users**  
Wishlists are saved for guest users using browser storage (cookies/localStorage) and for logged-in users in their account.

✅ **User Account Wishlist Tab**  
For logged-in users, adds a "Wishlist" tab in their WooCommerce My Account section.

✅ **Gutenberg Block Support**  
Easily add wishlist buttons in Gutenberg using a dedicated block.

✅ **Customizable Button Placement**  
Choose where to show wishlist buttons: above image, before/after add to cart, or insert manually using a shortcode.

✅ **Custom Button Text**  
Set custom text for both "Add to Wishlist" and "Remove from Wishlist" buttons.

✅ **AJAX Support**  
Instantly add or remove items from wishlist without page reloads.

✅ **Shortcodes**  
Use `[wishlist_everywhere]` to display the user’s wishlist anywhere on your site.

✅ **Custom Styling Options**  
Add your own CSS for button styles, layout adjustments, or animations.

✅ **Optimized & Lightweight**  
Built for speed with clean code and minimal database usage.

✅ **Wishlist Sharing**  
Users can now copy wishlist links to clipboard or share directly on Facebook, Twitter, and Pinterest.

✅ **Analytics Dashboard** 
Store admins can view wishlist items in the backend
  - View most wishlisted products
  - View top users with wishlist activity
  - Track wishlist activity even after items are removed
  - Visual charts powered by Chart.js

== 💡 Use Cases ==

🛍️ **WooCommerce Stores** – Let shoppers save favorites for future purchases.  
📰 **Blogs & Content Sites** – Allow readers to bookmark articles and guides.  
🎫 **Event Listings** – Let users track and save events they’re interested in.  
🏘️ **Real Estate** – Visitors can save properties to revisit later.  
🎓 **Educational Portals** – Students can wishlist courses, documents, and videos.

== 📦 What’s Included ==

- Universal wishlist support for all post types  
- WooCommerce-ready functionality  
- Wishlist on product archives and detail pages  
- Button position controls  
- AJAX-powered actions add/remove  
- Shortcode support: `[wishlist_everywhere]`  
- User account tab for wishlists  
- Gutenberg block  
- Custom post type settings  
- Guest and user account wishlist support 
- Wishlist sharing (clipboard + social platforms)  
- Developer-friendly structure  
- Styling customizer via CSS box



== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wishlist-everywhere` directory.
2. Activate the plugin through the ‘Plugins’ screen in WordPress.
3. Go to **Settings > Wishlist** in the admin dashboard to configure which post types to support.
4. Customize the post types, button labels, and placement.
5. Add `[wishlist_everywhere]` to any page where you want the wishlist to appear.
6. Visit **Dashboard → Wihlist Everywhere → Wishlist Analytics** to see insights.


== Shortcodes ==

`[wishlist_everywhere]`  
Displays the wishlist for the current user (guest or logged-in).

== Frequently Asked Questions ==

= Does this plugin support WooCommerce? =  
Yes, WooCommerce products are fully supported, including price display, add-to-cart functionality, and AJAX compatibility.

= Can I use this wishlist with custom post types? =  
Absolutely. The plugin supports all custom post types. You can enable wishlist functionality for any post type from the plugin settings.

= Can I change the "Add to Wishlist" button text? =  
Yes, you can easily customize the "Add to Wishlist" text from the plugin settings panel.

= Can I customize the "Remove from Wishlist" text? =  
Yes, the plugin provides an option to change the "Remove from Wishlist" label as well, giving you full control over the button language.

= What happens to guest user wishlists after login? =  
Guest wishlists currently remain in the browser. For syncing with accounts, a future version may include merging options.

= Can I choose where the button appears? =  
Yes. You can set button positions from the settings: before/after Add to Cart, above the thumbnail, or use shortcodes for custom placement.

= Do I need to manually create a wishlist page? =  
No, you don’t have to create a page manually. The plugin handles the wishlist page setup. However, you can also add the `[wishlist_everywhere]` shortcode to any page where you want to display the wishlist items.

= Can I show the wishlist on any page? =  
Yes, you can use the provided `[wishlist_everywhere]` shortcode to display the wishlist items on any page or post.

= Does it work with any WordPress theme? =  
Yes, the plugin is designed to work with all standard WordPress themes. For best results, use a theme that follows WordPress coding standards. 

= Can users share their wishlist with others? =  
Yes! Users can copy their wishlist URL to the clipboard or share it directly on Facebook, Twitter, or Pinterest.

= Can I track which products are most popular? =
Yes. The new Analytics Dashboard shows your most wishlisted products.

= Does it still track when a user removes an item from their wishlist? =
Yes. Wishlist activity is logged permanently for analytics purposes.

= Where can I find analytics? =
Go to your WordPress Dashboard → Wihlist Everywhere → **Wishlist Analytics**.



== Screenshots ==

1. Admin settings panel for configuring wishlist options.
2. Detailed view of the wishlist settings page in the admin dashboard.
3. Choose from preset positions or insert manually using a shortcode.
4. Wishlist icon displayed on the product page.
5. Frontend wishlist page showing saved items using the shortcode.
6. Wishlist popup displaying saved products in real time.

== Changelog ==

= 1.0 =
* Initial release

= 1.0.5 =
* Updated PHP logic for message formatting
* Added Archive and Single Option for product page
* Added Heart icon in archive page

= 1.0.6 =
Major Update Highlights:
✨ Guest User Support – Wishlists can now be used without logging in
🛍️ Product Listing & Product Detail Page Options – Enable wishlist buttons on archive and single product pages
📌 Flexible Wishlist Button Placement – Choose from preset positions or insert manually using a shortcode
🔧 WooCommerce Enhancements – Improved compatibility and smoother integration
🎨 Custom CSS Styling Option – Easily style wishlist buttons to match your theme
🚀 Enhanced Frontend UI/UX – Smoother interactions with AJAX and modern design improvements


= 1.0.7 =
New Features:
🛒 Add All to Cart – One-click button to add all wishlist items to the cart
🗑️ Remove All Items – Bulk removal of all items from wishlist

= 1.0.8 =
Wishlist Sharing Introduced:
📤 Wishlist Sharing – Copy wishlist link to clipboard or share via social media
🔗 Copy to Clipboard – Easily copy and share your wishlist link
📣 Social Sharing Support – Share your wishlist via Facebook, Twitter, and Pinterest

= 1.0.9 =
🎨 Minor CSS fix

= 1.1.0 =
🔧 Fixed Elementor compatibility issue 
✨ Add Wishlist Share Page


= 1.1.1 =
📊 Added Wishlist Analytics Dashboard for admins  
⭐ Track most wishlisted products  
👤 Track top users by wishlist activity  
📈 Added Chart.js for visual reporting  
🔒 Wishlist activity stored permanently (even after items are removed) 


= 1.1.2 =
🎨 Added admin Font Awesome icons
🔤 Added custom plugin fonts
🛠️ Fixed array issue on the product detail page