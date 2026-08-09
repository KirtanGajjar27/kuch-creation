<?php
/**
 * Core theme supports, menus, image sizes, and the Avada/Fusion asset dequeue
 * that keeps storefront-critical templates light.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function kc_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		[ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ]
	);

	register_nav_menus(
		[
			'primary' => __( 'Primary Navigation', 'kuchcreation' ),
			'footer'  => __( 'Footer Navigation', 'kuchcreation' ),
		]
	);

	add_image_size( 'kc-product-card', 800, 1000, true );
	add_image_size( 'kc-category-card', 1000, 1250, true );
	add_image_size( 'kc-hero', 1800, 1200, true );
}
add_action( 'after_setup_theme', 'kc_theme_setup' );

/**
 * True on any template we hand-code ourselves (no Fusion Builder markup involved).
 * Used to decide whether Avada/Fusion's bundled CSS/JS can be safely dropped.
 */
function kc_is_custom_storefront_template() {
	return is_front_page() || is_shop() || is_product() || is_product_category()
		|| is_cart() || is_checkout() || is_account_page() || is_search();
}

/**
 * Fusion Builder/Core enqueue a large CSS/JS bundle (grid system, builder-only
 * widgets, animation library) that our hand-coded templates don't use. Dropping
 * it there is the main lever for keeping those pages light per the performance
 * requirement, without touching Avada elsewhere (e.g. static pages built with
 * Fusion Builder keep working normally).
 */
function kc_dequeue_builder_assets_on_storefront() {
	if ( ! kc_is_custom_storefront_template() ) {
		return;
	}

	$handles_to_drop = [
		'avada-stylesheet',
		'fusion-dynamic-css',
		'fusion-scripts',
		'fusion-slider',
		'fusion-sticky-header',
	];

	foreach ( $handles_to_drop as $handle ) {
		wp_dequeue_style( $handle );
		wp_dequeue_script( $handle );
	}
}
add_action( 'wp_print_styles', 'kc_dequeue_builder_assets_on_storefront', 100 );
add_action( 'wp_print_scripts', 'kc_dequeue_builder_assets_on_storefront', 100 );
