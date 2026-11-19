<?php
/**
 * Plugin Name: CrediMark Badges for WooCommerce
 * Plugin URI: https://karazshop.ae/
 * Description: Show conversion-focused product trust badges (warranty, free delivery, easy returns, COD) and optional review widgets below the product gallery on WooCommerce single product pages.
 * Version: 1.0.0
 * Author: ShopForge Labs
 * Author URI: https://mudassar.net/
 * Text Domain: credimark-badges-for-woocommerce
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 5.0
 * WC tested up to: 9.0
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package CrediMark_Badges
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CMTB_VERSION', '1.0.0' );
define( 'CMTB_FILE', __FILE__ );
define( 'CMTB_PATH', plugin_dir_path( __FILE__ ) );
define( 'CMTB_URL', plugin_dir_url( __FILE__ ) );

/**
 * Declare HPOS Compatibility
 */
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

/**
 * Main Class Initialization
 */
require_once CMTB_PATH . 'includes/class-trust-badges.php';

function credimark_badges_init() {
	CrediMark_Badges::get_instance();
}
add_action( 'plugins_loaded', 'credimark_badges_init' );
