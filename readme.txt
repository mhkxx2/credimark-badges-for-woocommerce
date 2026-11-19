=== CrediMark Badges for WooCommerce ===
Contributors: shopforgelabs, mhkxx2
Tags: woocommerce, trust badges, product badges, social proof, conversion, warranty badge, free delivery, cash on delivery, returns policy, product page, ecommerce trust
Requires at least: 5.8
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Boost WooCommerce product-page conversions with warranty, free delivery, easy returns, and COD trust badges under the product gallery.

== Description ==

**CrediMark Badges for WooCommerce** adds a clean, conversion-focused trust strip directly under your product gallery. Shoppers see clear buying guarantees—warranty, free delivery, easy returns, and cash on delivery—exactly when they are deciding to purchase.

Unlike generic icon widgets, CrediMark is built for WooCommerce single product pages, works with classic templates and page builders (including Elementor / WoodMart gallery widgets), and ships with an optional review-widget row for social proof.

= Why store owners use CrediMark =

* Increase add-to-cart confidence with visible product guarantees
* Reduce purchase anxiety on high-ticket electronics and appliance stores
* Keep trust signals next to the product image—where shoppers actually look
* Match modern storefront design with a lightweight, responsive layout
* Place badges anywhere with a shortcode when using custom builders

= Core features =

* **Product trust badge grid** – Warranty, Free Delivery, Easy Return, Cash on Delivery
* **Gallery-aware placement** – Renders below the product image / gallery area
* **Page builder friendly** – Elementor / WoodMart gallery widget filter support
* **Shortcode support** – `[credimark_badges]` for custom layouts
* **Optional review row** – Connect a review-platform badge or profile link
* **Filterable badge items** – Developers can customize labels via hooks
* **HPOS compatible** – Declares WooCommerce High-Performance Order Storage support
* **Lightweight assets** – CSS/JS loaded only on product pages

= Perfect for =

* Electronics and appliance stores
* UAE / GCC cash-on-delivery shops
* Stores that sell with store warranty and express delivery promises
* High-AOV catalogs that need stronger social proof near the buy box

= Developer friendly =

* Filter: `credimark_badges_items` to customize badge content
* Filter: `credimark_review_config` to control the review row
* Shortcode: `[credimark_badges]`
* Clean singleton architecture, no bloat


= Links =

* Live website: https://karazshop.ae/
* Developer website: https://mudassar.net/
* Plugin URI: https://github.com/mhkxx2/credimark-badges-for-woocommerce

== Installation ==

1. Upload the `credimark-badges-for-woocommerce` folder to `/wp-content/plugins/`
2. Activate **CrediMark Badges for WooCommerce** through the Plugins screen
3. Open any WooCommerce product page to see the trust badges under the gallery
4. Optional: place `[credimark_badges]` in a custom product template or Elementor block

== Frequently Asked Questions ==

= Does this require WooCommerce? =

Yes. CrediMark is designed for WooCommerce single product pages.

= Where do the badges appear? =

By default they render below the product gallery / images on the single product page. You can also place them with the shortcode.

= Can I change badge titles and subtitles? =

Yes. Developers can use the `credimark_badges_items` filter. A settings UI can be extended in future releases.

= Is it compatible with Elementor and WoodMart? =

Yes. The plugin hooks into Elementor widget output for product gallery widgets and also uses the standard WooCommerce product template hook.

= Will it slow my site down? =

No. Styles and scripts load only on product pages and are kept minimal.

== Screenshots ==

1. Trust badge grid under the product gallery
2. Optional review / rating row above the badges
3. Mobile-optimized badge layout

== Changelog ==

= 1.0.0 =
* Initial public release
* Product trust badge grid (warranty, delivery, returns, COD)
* Elementor / WoodMart gallery placement support
* Shortcode + developer filters
* Optional review-widget row
* WooCommerce HPOS compatibility declaration

== Upgrade Notice ==

= 1.0.0 =
First public release of CrediMark Badges for WooCommerce.
