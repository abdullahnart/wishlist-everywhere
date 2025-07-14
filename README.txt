=== Wishlist Everywhere ===
Contributors: abdullahart
Tags: wishlist, post types, custom post types, WooCommerce
Requires at least: 5.0
Tested up to: 6.8
Stable tag: 1.0.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Short Description: A plugin that adds a wishlist feature for your website, allowing users to save and manage their favorite items.


== Description ==

Wishlist Everywhere adds a flexible and easy-to-use wishlist system to your WordPress website. Let users save products, posts, or any custom content types to a personal wishlist. Works for both logged-in and guest users. Perfect for WooCommerce stores, blogs, event sites, real estate platforms, and more.

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
- Developer-friendly structure  
- Styling customizer via CSS box



== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wishlist-everywhere` directory.
2. Activate the plugin through the ‘Plugins’ screen in WordPress.
3. Go to **Settings > Wishlist** in the admin dashboard to configure which post types to support.
4. Customize the post types, button labels, and placement.
5. Add `[wishlist_everywhere]` to any page where you want the wishlist to appear.


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

== Upgrade Notice ==

= 1.0 =
First stable version.

= 1.0.5 =
* Updated PHP logic for message formatting
* Added Archive and Single Option for product page
* Added Heart icon in archive page

== Upgrade Notice ==

= 1.0.6 =
Major Update Highlights:
✨ Guest User Support – Wishlists can now be used without logging in
🛍️ Product Listing & Product Detail Page Options – Enable wishlist buttons on archive and single product pages
📌 Flexible Wishlist Button Placement – Choose from preset positions or insert manually using a shortcode
🔧 WooCommerce Enhancements – Improved compatibility and smoother integration
🎨 Custom CSS Styling Option – Easily style wishlist buttons to match your theme
🚀 Enhanced Frontend UI/UX – Smoother interactions with AJAX and modern design improvements

