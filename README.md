# CrediMark Badges for WooCommerce

**SEO tagline:** Boost WooCommerce conversions with product-page trust badges for warranty, free delivery, easy returns, and cash on delivery.

[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![WordPress](https://img.shields.io/badge/WordPress-5.8%2B-blue.svg)](https://wordpress.org/)
[![WooCommerce](https://img.shields.io/badge/WooCommerce-5.0%2B-purple.svg)](https://woocommerce.com/)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4.svg)](https://www.php.net/)

CrediMark Badges for WooCommerce displays a conversion-focused trust strip under your product gallery so shoppers see guarantees at the exact moment of purchase.

## Features

- Warranty, Free Delivery, Easy Return, and Cash on Delivery badges
- Placement under the WooCommerce product gallery
- Elementor / WoodMart gallery widget compatibility
- Shortcode: `[credimark_badges]`
- Optional review / rating row
- Developer filters for badge items and review config
- WooCommerce HPOS compatible
- Assets load only on product pages

## Installation

1. Download or clone this repository into `wp-content/plugins/credimark-badges-for-woocommerce`
2. Activate **CrediMark Badges for WooCommerce**
3. Visit a product page to see the badges

## Shortcode

```
[credimark_badges]
```

## Hooks

```php
add_filter( 'credimark_badges_items', function( $items ) {
    // Customize badge title/subtitle/icon map
    return $items;
} );

add_filter( 'credimark_review_config', function( $config ) {
    // Enable/disable review row and set profile URL / widget IDs
    return $config;
} );
```

## Requirements

- WordPress 5.8+
- PHP 7.4+
- WooCommerce 5.0+

## License

GPLv2 or later. See [LICENSE](LICENSE).

## Author

ShopForge Labs · [GitHub @mhkxx2](https://github.com/mhkxx2)
