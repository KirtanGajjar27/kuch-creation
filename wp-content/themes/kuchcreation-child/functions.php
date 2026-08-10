<?php
/**
 * Kuch Creation child theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KC_THEME_VERSION', '0.1.0' );
define( 'KC_THEME_DIR', get_stylesheet_directory() );
define( 'KC_THEME_URI', get_stylesheet_directory_uri() );

require_once KC_THEME_DIR . '/inc/theme-setup.php';
require_once KC_THEME_DIR . '/inc/woocommerce.php';
require_once KC_THEME_DIR . '/inc/customizer.php';
require_once KC_THEME_DIR . '/inc/ajax.php';
require_once KC_THEME_DIR . '/inc/newsletter.php';
require_once KC_THEME_DIR . '/inc/account.php';

/**
 * Preconnect to Google Fonts so the DM Sans request doesn't wait on DNS/TLS.
 */
function kc_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = [ 'href' => 'https://fonts.gstatic.com', 'crossorigin' ];
		$urls[] = 'https://fonts.googleapis.com';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'kc_resource_hints', 10, 2 );

/**
 * Enqueue parent (Avada) stylesheet, then our own design-system stylesheets on top.
 * Storefront-critical pages (front page, shop, product, cart, checkout, account)
 * additionally drop Avada/Fusion's bundled CSS/JS — see inc/theme-setup.php.
 */
function kc_enqueue_assets() {
	wp_enqueue_style( 'avada-parent-style', get_template_directory_uri() . '/style.css', [], KC_THEME_VERSION );

	wp_enqueue_style( 'kc-google-fonts', 'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&display=swap', [], null );
	wp_enqueue_style( 'kc-tokens', KC_THEME_URI . '/assets/css/tokens.css', [ 'avada-parent-style', 'kc-google-fonts' ], KC_THEME_VERSION );
	wp_enqueue_style( 'kc-base', KC_THEME_URI . '/assets/css/base.css', [ 'kc-tokens' ], KC_THEME_VERSION );
	wp_enqueue_style( 'kc-header', KC_THEME_URI . '/assets/css/header.css', [ 'kc-base' ], KC_THEME_VERSION );
	wp_enqueue_style( 'kc-footer', KC_THEME_URI . '/assets/css/footer.css', [ 'kc-base' ], KC_THEME_VERSION );
	wp_enqueue_style( 'kc-product-card', KC_THEME_URI . '/assets/css/product-card.css', [ 'kc-base' ], KC_THEME_VERSION );

	if ( is_front_page() ) {
		wp_enqueue_style( 'kc-homepage', KC_THEME_URI . '/assets/css/homepage.css', [ 'kc-product-card' ], KC_THEME_VERSION );
	}

	if ( is_shop() || is_product_category() || is_product() || is_cart() || is_checkout() || is_account_page() || is_search() || is_404() ) {
		wp_enqueue_style( 'kc-woocommerce-pages', KC_THEME_URI . '/assets/css/woocommerce-pages.css', [ 'kc-product-card' ], KC_THEME_VERSION );
	}

	if ( is_account_page() && ! is_user_logged_in() ) {
		wp_enqueue_style( 'kc-auth', KC_THEME_URI . '/assets/css/auth.css', [ 'kc-woocommerce-pages' ], KC_THEME_VERSION );
	}

	// WooCommerce's own AJAX add-to-cart + cart-fragments — real cart behavior,
	// not a custom reimplementation. Needed here because product cards render
	// on the homepage outside WooCommerce's normal shop/archive templates.
	if ( is_front_page() || is_shop() || is_product_category() || is_product() || is_search() || is_404() ) {
		wp_enqueue_script( 'wc-add-to-cart' );
		wp_enqueue_script( 'wc-cart-fragments' );
	}

	wp_enqueue_script( 'kc-app', KC_THEME_URI . '/assets/js/kc-app.js', [ 'jquery' ], KC_THEME_VERSION, true );
	wp_localize_script(
		'kc-app',
		'kcData',
		[
			'ajaxUrl'          => admin_url( 'admin-ajax.php' ),
			'searchNonce'      => wp_create_nonce( 'kc_search' ),
			'quickViewNonce'   => wp_create_nonce( 'kc_quick_view' ),
			'newsletterNonce'  => wp_create_nonce( 'kc_newsletter' ),
			'checkoutUrl'      => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : '',
		]
	);

	if ( kc_is_custom_storefront_template() ) {
		wp_enqueue_script( 'kc-gsap', KC_THEME_URI . '/assets/js/vendor/gsap.min.js', [], KC_THEME_VERSION, true );
		wp_enqueue_script( 'kc-gsap-scrolltrigger', KC_THEME_URI . '/assets/js/vendor/ScrollTrigger.min.js', [ 'kc-gsap' ], KC_THEME_VERSION, true );
		wp_enqueue_script( 'kc-scroll-reveal', KC_THEME_URI . '/assets/js/scroll-reveal.js', [ 'kc-gsap-scrolltrigger' ], KC_THEME_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'kc_enqueue_assets', 20 );
