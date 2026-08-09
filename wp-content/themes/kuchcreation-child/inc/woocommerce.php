<?php
/**
 * WooCommerce integration: declare support, then strip WooCommerce's own
 * frontend CSS so every visual decision comes from our design tokens instead
 * of two competing stylesheets. Template markup itself is overridden via the
 * theme's /woocommerce/ directory (added in a later step, per WC convention).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function kc_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'kc_woocommerce_setup' );

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
