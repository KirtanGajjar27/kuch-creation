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
	add_theme_support(
		'custom-logo',
		[
			'height'      => 64,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		]
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
		|| is_cart() || is_checkout() || is_account_page() || is_search() || is_404();
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

/**
 * Basic meta description — nothing on this stack (no SEO plugin installed)
 * emits one otherwise, and the spec calls for meta-friendly structure.
 */
function kc_meta_description() {
	$description = '';

	if ( is_front_page() ) {
		$description = __( 'Handmade jewellery, cuffs and hair accessories in the mirror-work tradition of Kutch — made to order in small batches by Kuch Creation.', 'kuchcreation' );
	} elseif ( is_product() ) {
		global $product;
		if ( $product instanceof WC_Product ) {
			$description = wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() );
		}
	} elseif ( is_product_category() || is_tax() ) {
		$description = wp_strip_all_tags( term_description() );
	} elseif ( is_singular() ) {
		$description = wp_strip_all_tags( get_the_excerpt() );
	}

	$description = trim( $description );
	if ( ! $description ) {
		return;
	}

	printf( '<meta name="description" content="%s">' . "\n", esc_attr( wp_trim_words( $description, 30 ) ) );
}
add_action( 'wp_head', 'kc_meta_description', 1 );

/**
 * Open Graph tags for link previews — built from the same real data as the
 * meta description above, no separate/fake content.
 */
function kc_open_graph_tags() {
	$title = get_bloginfo( 'name' );
	$image = '';

	if ( is_product() ) {
		global $product;
		if ( $product instanceof WC_Product ) {
			$title = $product->get_name();
			$image = wp_get_attachment_image_url( $product->get_image_id(), 'large' );
		}
	} elseif ( is_singular() ) {
		$title = get_the_title();
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( null, 'large' );
		}
	}

	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( home_url( add_query_arg( null, null ) ) ) );
	printf( '<meta property="og:type" content="%s">' . "\n", is_product() ? 'product' : 'website' );
	if ( $image ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	}
}
add_action( 'wp_head', 'kc_open_graph_tags', 2 );

/**
 * Organization/WebSite structured data on the homepage — Product schema is
 * handled separately in inc/woocommerce.php for single-product pages.
 */
function kc_organization_structured_data() {
	if ( ! is_front_page() ) {
		return;
	}

	$logo_id = get_theme_mod( 'custom_logo' );

	$data = [
		'@context' => 'https://schema.org',
		'@type'    => 'Organization',
		'name'     => get_bloginfo( 'name' ),
		'url'      => home_url( '/' ),
	];

	if ( $logo_id ) {
		$data['logo'] = wp_get_attachment_image_url( $logo_id, 'full' );
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $data ) . '</script>' . "\n"; // phpcs:ignore
}
add_action( 'wp_head', 'kc_organization_structured_data' );

/**
 * Prints the primary nav. Falls back to Shop + real product category links
 * when no menu has been assigned yet in Appearance > Menus, so navigation
 * is never empty on a fresh install.
 */
function kc_primary_menu( $mobile = false ) {
	$container_class = $mobile ? 'kc-mobile-menu__list' : 'kc-nav__list';

	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu(
			[
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => $container_class,
				'depth'          => 2,
			]
		);
		return;
	}

	$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
	$links    = [
		[ 'label' => __( 'Shop', 'kuchcreation' ), 'url' => $shop_url ],
	];

	if ( function_exists( 'get_term_link' ) ) {
		foreach ( [ 'jewellery' => __( 'Jewellery', 'kuchcreation' ), 'hair-accessories' => __( 'Hair Accessories', 'kuchcreation' ) ] as $slug => $label ) {
			$term = get_term_by( 'slug', $slug, 'product_cat' );
			if ( $term && ! is_wp_error( $term ) ) {
				$links[] = [ 'label' => $label, 'url' => get_term_link( $term ) ];
			}
		}
	}

	$links[] = [ 'label' => __( 'About', 'kuchcreation' ), 'url' => home_url( '/about-us/' ) ];

	echo '<ul class="' . esc_attr( $container_class ) . '">';
	foreach ( $links as $link ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $link['url'] ), esc_html( $link['label'] ) );
	}
	echo '</ul>';
}
