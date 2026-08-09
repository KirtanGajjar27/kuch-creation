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
	// Real WC gallery behavior (thumbnail nav, hover zoom, fullscreen lightbox)
	// instead of hand-rolling our own — matches the single-product spec without
	// reimplementing what WooCommerce already ships.
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'kc_woocommerce_setup' );

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Trust indicators near the place-order button — added via WC's own hook so
 * the checkout form markup (and any payment gateway JS bound to it) is
 * never touched.
 */
function kc_checkout_trust_indicators() {
	$items = [
		__( 'Secure Checkout', 'kuchcreation' ),
		__( 'Encrypted Payment', 'kuchcreation' ),
		__( 'Easy Returns', 'kuchcreation' ),
	];
	echo '<div class="kc-checkout-trust">';
	foreach ( $items as $item ) {
		echo '<span>&#10003; ' . esc_html( $item ) . '</span>';
	}
	echo '</div>';
}
add_action( 'woocommerce_review_order_after_submit', 'kc_checkout_trust_indicators' );

/**
 * "Buy Now" — sits next to the standard Add to Cart button. Reuses
 * WooCommerce's own add-to-cart AJAX endpoint (kc-buy-now.js posts to it)
 * then redirects straight to checkout, rather than a separate cart/order
 * code path.
 */
function kc_buy_now_button() {
	global $product;
	if ( ! $product instanceof WC_Product || ! $product->is_purchasable() || ! $product->is_in_stock() || ! $product->is_type( 'simple' ) ) {
		return;
	}
	printf(
		'<button type="button" class="kc-btn kc-btn-outline kc-buy-now" data-product-id="%d">%s</button>',
		esc_attr( $product->get_id() ),
		esc_html__( 'Buy Now', 'kuchcreation' )
	);
}
add_action( 'woocommerce_single_product_summary', 'kc_buy_now_button', 31 );

/**
 * Shipping/returns reassurance directly on the buy box, not just buried in
 * a tab — per the single-product spec.
 */
function kc_product_shipping_returns_note() {
	?>
	<div class="kc-product-page__trust kc-small kc-muted">
		<p>&#128230; <?php esc_html_e( 'Handmade to order — ships in 3-5 business days.', 'kuchcreation' ); ?> <a href="<?php echo esc_url( home_url( '/shipping-delivery/' ) ); ?>"><?php esc_html_e( 'Shipping details', 'kuchcreation' ); ?></a></p>
		<p>&#8635; <?php esc_html_e( 'Not quite right?', 'kuchcreation' ); ?> <a href="<?php echo esc_url( home_url( '/refund_returns/' ) ); ?>"><?php esc_html_e( 'Our return policy', 'kuchcreation' ); ?></a></p>
	</div>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'kc_product_shipping_returns_note', 41 );

// Note: no custom Product/Offer structured data here — WooCommerce core
// (WC_Structured_Data) already emits complete Product + BreadcrumbList
// JSON-LD on single product pages automatically. A hand-rolled duplicate
// would just be redundant (confirmed live: WC's own output already covers
// price, sale price, stock, seller, and breadcrumbs).
