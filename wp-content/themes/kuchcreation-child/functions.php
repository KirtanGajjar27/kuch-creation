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

/**
 * Enqueue parent (Avada) stylesheet, then our own design-system stylesheets on top.
 * Storefront-critical pages (front page, shop, product, cart, checkout, account)
 * additionally drop Avada/Fusion's bundled CSS/JS — see inc/theme-setup.php.
 */
function kc_enqueue_assets() {
	wp_enqueue_style( 'avada-parent-style', get_template_directory_uri() . '/style.css', [], KC_THEME_VERSION );

	wp_enqueue_style( 'kc-tokens', KC_THEME_URI . '/assets/css/tokens.css', [ 'avada-parent-style' ], KC_THEME_VERSION );
	wp_enqueue_style( 'kc-base', KC_THEME_URI . '/assets/css/base.css', [ 'kc-tokens' ], KC_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'kc_enqueue_assets', 20 );
