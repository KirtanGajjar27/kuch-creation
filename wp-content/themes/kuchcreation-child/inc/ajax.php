<?php
/**
 * AJAX layer. Cart updates ride WooCommerce's own fragments API (not a
 * custom cart reimplementation, per the "customize the frontend, don't
 * recreate WooCommerce" rule) — we only supply the fragment markup. Search
 * is a small custom endpoint since WooCommerce has no built-in live-search.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function kc_cart_fragments( $fragments ) {
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;

	ob_start();
	?>
	<span class="kc-cart-count" id="kc-cart-count"><?php echo esc_html( $count ); ?></span>
	<?php
	$fragments['#kc-cart-count'] = ob_get_clean();

	ob_start();
	?>
	<div class="kc-cart-drawer__body" id="kc-cart-drawer-body">
		<?php get_template_part( 'template-parts/components/mini-cart' ); ?>
	</div>
	<?php
	$fragments['#kc-cart-drawer-body'] = ob_get_clean();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'kc_cart_fragments' );

function kc_ajax_search_products() {
	check_ajax_referer( 'kc_search', 'nonce' );

	$term = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';

	if ( strlen( $term ) < 2 ) {
		wp_send_json_success( [] );
	}

	$query = new WP_Query(
		[
			'post_type'      => 'product',
			'post_status'    => 'publish',
			's'              => $term,
			'posts_per_page' => 6,
		]
	);

	$results = [];
	foreach ( $query->posts as $post ) {
		$product = wc_get_product( $post->ID );
		if ( ! $product ) {
			continue;
		}
		$results[] = [
			'id'        => $product->get_id(),
			'title'     => $product->get_name(),
			'permalink' => get_permalink( $product->get_id() ),
			'price'     => wp_strip_all_tags( $product->get_price_html() ),
			'image'     => wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' ) ?: wc_placeholder_img_src(),
		];
	}

	wp_reset_postdata();
	wp_send_json_success( $results );
}
add_action( 'wp_ajax_kc_search_products', 'kc_ajax_search_products' );
add_action( 'wp_ajax_nopriv_kc_search_products', 'kc_ajax_search_products' );

function kc_ajax_quick_view() {
	check_ajax_referer( 'kc_quick_view', 'nonce' );

	$product_id = isset( $_GET['product_id'] ) ? absint( $_GET['product_id'] ) : 0;
	$product    = wc_get_product( $product_id );

	if ( ! $product ) {
		wp_send_json_error();
	}

	ob_start();
	?>
	<div class="kc-quick-view__media">
		<?php echo $product->get_image( 'kc-product-card' ); // phpcs:ignore ?>
	</div>
	<div class="kc-quick-view__info">
		<h2 class="kc-h3"><?php echo esc_html( $product->get_name() ); ?></h2>
		<div class="kc-product-card__rating"><?php echo wc_get_rating_html( $product->get_average_rating() ); // phpcs:ignore ?></div>
		<p class="kc-quick-view__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
		<div class="kc-quick-view__desc"><?php echo wp_kses_post( wpautop( $product->get_short_description() ) ); ?></div>
		<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" class="kc-btn kc-btn-primary kc-add-to-cart ajax_add_to_cart add_to_cart_button" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" rel="nofollow">
			<?php echo esc_html( $product->add_to_cart_text() ); ?>
		</a>
		<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="kc-btn kc-btn-outline"><?php esc_html_e( 'View Full Details', 'kuchcreation' ); ?></a>
	</div>
	<?php
	wp_send_json_success( ob_get_clean() );
}
add_action( 'wp_ajax_kc_quick_view', 'kc_ajax_quick_view' );
add_action( 'wp_ajax_nopriv_kc_quick_view', 'kc_ajax_quick_view' );
