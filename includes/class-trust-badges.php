<?php
/**
 * Class CrediMark_Badges
 *
 * Handles rendering and assets for single product trust badges and reviews.
 *
 * @package CrediMark_Badges
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CrediMark_Badges {

	/**
	 * Singleton instance
	 *
	 * @var CrediMark_Badges|null
	 */
	private static $instance = null;

	/**
	 * Rendered flag to prevent duplicate output
	 *
	 * @var bool
	 */
	private static $has_rendered = false;

	/**
	 * Get singleton instance
	 *
	 * @return CrediMark_Badges
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		
		// 1. Hook for WoodMart Elementor Layout Builder (Product Gallery Widget)
		add_filter( 'elementor/widget/render_content', array( $this, 'filter_elementor_gallery_widget' ), 10, 2 );

		// 2. Standard WooCommerce Single Product Template Hook
		add_action( 'woocommerce_before_single_product_summary', array( $this, 'render_trust_badges_section' ), 25 );

		// 3. Shortcode for custom Elementor blocks / page builders
		add_shortcode( 'credimark_badges', array( $this, 'render_trust_badges_shortcode' ) );
	}

	/**
	 * Enqueue stylesheet on single product pages
	 */
	public function enqueue_assets() {
		if ( ! is_product() ) {
			return;
		}

		$css_file = CMTB_PATH . 'assets/css/trust-badges.css';
		$css_ver  = file_exists( $css_file ) ? (string) filemtime( $css_file ) : CMTB_VERSION;

		wp_enqueue_style(
			'credimark-trust-badges-css',
			CMTB_URL . 'assets/css/trust-badges.css',
			array(),
			$css_ver
		);

		$js_file = CMTB_PATH . 'assets/js/trust-badges.js';
		$js_ver  = file_exists( $js_file ) ? (string) filemtime( $js_file ) : CMTB_VERSION;

		wp_enqueue_script(
			'credimark-trust-badges-js',
			CMTB_URL . 'assets/js/trust-badges.js',
			array(),
			$js_ver,
			true
		);
	}

	/**
	 * Append trust badges directly below WoodMart / Elementor gallery widget
	 *
	 * @param string $content
	 * @param \Elementor\Widget_Base $widget
	 * @return string
	 */
	public function filter_elementor_gallery_widget( $content, $widget ) {
		$target_widgets = array( 'wd_single_product_gallery', 'woocommerce-product-images', 'woocommerce-product-gallery' );
		
		if ( in_array( $widget->get_name(), $target_widgets, true ) ) {
			if ( ! self::$has_rendered ) {
				$badges_html = $this->get_trust_badges_html();
				if ( ! empty( $badges_html ) ) {
					self::$has_rendered = true;
					$content .= $badges_html;
				}
			}
		}

		return $content;
	}

	/**
	 * Get default trust badge items based on store policies
	 *
	 * @return array
	 */
	public function get_badge_items() {
		$items = array(
			array(
				'id'       => 'warranty',
				'icon'     => 'shield_check',
				'title'    => __( 'Warranty', 'credimark-badges-for-woocommerce' ),
				'subtitle' => __( '1 Year Store Warranty', 'credimark-badges-for-woocommerce' ),
				'url'      => '/return-refund-policy/',
			),
			array(
				'id'       => 'free_delivery',
				'icon'     => 'truck',
				'title'    => __( 'FREE DELIVERY', 'credimark-badges-for-woocommerce' ),
				'subtitle' => __( 'With Express delivery', 'credimark-badges-for-woocommerce' ),
				'url'      => '/shipping-policy/',
			),
			array(
				'id'       => 'easy_return',
				'icon'     => 'return_arrow',
				'title'    => __( 'EASY RETURN', 'credimark-badges-for-woocommerce' ),
				'subtitle' => __( '15 Days Return Policy', 'credimark-badges-for-woocommerce' ),
				'url'      => '/return-refund-policy/',
			),
			array(
				'id'       => 'cod',
				'icon'     => 'price_tag',
				'title'    => __( 'CASH ON DELIVERY', 'credimark-badges-for-woocommerce' ),
				'subtitle' => __( 'COD Across UAE', 'credimark-badges-for-woocommerce' ),
				'url'      => '',
			),
		);

		return apply_filters( 'credimark_badges_items', $items );
	}

	/**
	 * Get Trustpilot configuration
	 *
	 * @return array
	 */
	public function get_trustpilot_config() {
		$config = array(
			// Whether Trustpilot is connected and enabled
			'enabled'          => (bool) get_option( 'credimark_review_enabled', false ),
			'type'             => get_option( 'credimark_review_type', 'badge' ), // 'widget' or 'badge'
			'profile_url'      => get_option( 'credimark_review_profile_url', '' ),
			'business_unit_id' => get_option( 'credimark_review_business_id', '' ),
			'template_id'      => get_option( 'credimark_review_template_id', '' ),
			'rating_text'      => get_option( 'credimark_review_rating_text', 'Excellent customer reviews' ),
		);

		return apply_filters( 'credimark_review_config', $config );
	}

	/**
	 * Get rendered HTML string for Trust Badges Section
	 *
	 * @return string
	 */
	public function get_trust_badges_html() {
		$tp_config = $this->get_trustpilot_config();
		$badges    = $this->get_badge_items();

		if ( empty( $badges ) && empty( $tp_config['enabled'] ) ) {
			return '';
		}

		ob_start();
		?>
		<div class="credimark-product-trust-section" aria-label="<?php esc_attr_e( 'Product Guarantees and Trust Badges', 'credimark-badges-for-woocommerce' ); ?>">
			
			<?php if ( ! empty( $tp_config['enabled'] ) && ! empty( $tp_config['profile_url'] ) ) : ?>
				<div class="credimark-review-row">
					<?php if ( 'widget' === $tp_config['type'] && ! empty( $tp_config['business_unit_id'] ) ) : ?>
						<!-- Official Live Trustpilot Widget -->
						<div class="trustpilot-widget" 
							 data-locale="<?php echo esc_attr( get_locale() ); ?>" 
							 data-template-id="<?php echo esc_attr( $tp_config['template_id'] ?: '5419b6a8b0d04a076446a9ad' ); ?>" 
							 data-businessunit-id="<?php echo esc_attr( $tp_config['business_unit_id'] ); ?>" 
							 data-style-height="24px" 
							 data-style-width="100%" 
							 data-theme="light">
							<a href="<?php echo esc_url( $tp_config['profile_url'] ); ?>" target="_blank" rel="noopener noreferrer">Trustpilot</a>
						</div>
					<?php else : ?>
						<!-- Live Trustpilot Direct Link -->
						<a href="<?php echo esc_url( $tp_config['profile_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="credimark-tp-link">
							<span class="credimark-tp-text"><?php echo esc_html( $tp_config['rating_text'] ); ?></span>
							<span class="credimark-tp-stars" aria-hidden="true">★★★★★</span>
							<span class="credimark-tp-brand">
								<svg class="credimark-tp-logo-star" viewBox="0 0 24 24" width="16" height="16" fill="#00b67a" aria-hidden="true">
									<path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
								</svg>
								<span class="credimark-tp-brand-name">Trustpilot</span>
							</span>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $badges ) ) : ?>
				<div class="credimark-trust-badges-grid">
					<?php foreach ( $badges as $badge ) : ?>
						<div class="credimark-trust-badge-item" id="credimark-tb-<?php echo esc_attr( $badge['id'] ); ?>">
							<div class="credimark-trust-badge-icon-wrap">
								<?php echo self::get_icon_svg( $badge['icon'] ); ?>
							</div>
							<div class="credimark-trust-badge-content">
								<div class="credimark-trust-badge-title"><?php echo esc_html( $badge['title'] ); ?></div>
								<div class="credimark-trust-badge-subtitle"><?php echo esc_html( $badge['subtitle'] ); ?></div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render the Trust Badges Section directly (for standard WooCommerce hook)
	 */
	public function render_trust_badges_section() {
		if ( self::$has_rendered ) {
			return;
		}

		$html = $this->get_trust_badges_html();
		if ( ! empty( $html ) ) {
			self::$has_rendered = true;
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Shortcode callback
	 */
	public function render_trust_badges_shortcode() {
		return $this->get_trust_badges_html();
	}

	/**
	 * Helper to get clean vector line SVGs with cohesive 1.8px stroke
	 *
	 * @param string $icon_name
	 * @return string SVG markup
	 */
	public static function get_icon_svg( $icon_name ) {
		switch ( $icon_name ) {
			case 'shield_check':
				return '<svg class="credimark-trust-svg" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
					<path d="m9 12 2 2 4-4"/>
				</svg>';

			case 'truck':
				return '<svg class="credimark-trust-svg" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<rect x="1" y="4" width="14" height="12" rx="1"/>
					<path d="M15 8h4.5l3.5 4.5v3.5h-8V8z"/>
					<circle cx="5.5" cy="18.5" r="2.5"/>
					<circle cx="17.5" cy="18.5" r="2.5"/>
				</svg>';

			case 'return_arrow':
				return '<svg class="credimark-trust-svg" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
					<path d="M3 3v5h5"/>
					<circle cx="12" cy="12" r="1.5" fill="currentColor"/>
				</svg>';

			case 'chat_bubbles':
				return '<svg class="credimark-trust-svg" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
				</svg>';

			case 'price_tag':
			default:
				return '<svg class="credimark-trust-svg" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
					<circle cx="7" cy="7" r="1.5" fill="currentColor"/>
				</svg>';
		}
	}
}
