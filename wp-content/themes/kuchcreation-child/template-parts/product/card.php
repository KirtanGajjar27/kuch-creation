<?php
/**
 * ProductCard component. Usage:
 *   get_template_part( 'template-parts/product/card', null, [ 'product' => $product ] );
 */

if ( ! isset( $args['product'] ) || ! ( $args['product'] instanceof WC_Product ) ) {
	return;
}

/** @var WC_Product $product */
$product      = $args['product'];
$gallery_ids  = $product->get_gallery_image_ids();
$hover_img_id = $gallery_ids[0] ?? 0;
$is_on_sale   = $product->is_on_sale();
$is_bestseller = has_term( 'best-seller', 'product_tag', $product->get_id() );
?>
<article class="kc-product-card">
	<div class="kc-product-card__media">
		<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="kc-product-card__image-link" aria-label="<?php echo esc_attr( $product->get_name() ); ?>">
			<?php echo $product->get_image( 'kc-product-card', [ 'class' => 'kc-product-card__image kc-product-card__image--primary' ] ); // phpcs:ignore ?>
			<?php if ( $hover_img_id ) : ?>
				<?php echo wp_get_attachment_image( $hover_img_id, 'kc-product-card', false, [ 'class' => 'kc-product-card__image kc-product-card__image--hover' ] ); // phpcs:ignore ?>
			<?php endif; ?>
		</a>

		<div class="kc-product-card__badges">
			<?php if ( $is_on_sale ) : ?>
				<span class="kc-badge kc-badge--sale"><?php esc_html_e( 'Sale', 'kuchcreation' ); ?></span>
			<?php endif; ?>
			<?php if ( $is_bestseller ) : ?>
				<span class="kc-badge kc-badge--bestseller"><?php esc_html_e( 'Bestseller', 'kuchcreation' ); ?></span>
			<?php endif; ?>
		</div>

		<button
			type="button"
			class="kc-wishlist-btn"
			data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
			aria-pressed="false"
			aria-label="<?php esc_attr_e( 'Add to wishlist', 'kuchcreation' ); ?>"
		>
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
				<path d="M12 20.5s-7.5-4.6-10-9.3C.4 7.8 2 4.5 5.3 4c2-.3 3.9.6 5 2.2.7-1 2.4-2.5 5-2.2C18.6 4.5 20.2 7.8 18.7 11.2c-2.5 4.7-6.7 9.3-6.7 9.3Z"/>
			</svg>
		</button>

		<div class="kc-product-card__controls">
			<button type="button" class="kc-quick-view" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
				<?php esc_html_e( 'Quick View', 'kuchcreation' ); ?>
			</button>
		</div>
	</div>

	<div class="kc-product-card__body">
		<h3 class="kc-product-card__name">
			<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
		</h3>

		<?php if ( $product->get_short_description() ) : ?>
			<p class="kc-product-card__desc kc-small kc-muted"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $product->get_short_description() ), 8 ) ); ?></p>
		<?php endif; ?>

		<div class="kc-product-card__rating">
			<?php echo wc_get_rating_html( $product->get_average_rating() ); // phpcs:ignore ?>
		</div>

		<div class="kc-product-card__row">
			<span class="kc-product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
			<?php
			echo apply_filters( // phpcs:ignore
				'woocommerce_loop_add_to_cart_link',
				sprintf(
					'<a href="%s" data-quantity="1" class="%s" data-product_id="%d" data-product_sku="%s" aria-label="%s" rel="nofollow">%s</a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( 'kc-btn kc-btn-primary kc-add-to-cart ' . ( $product->is_type( 'simple' ) ? 'ajax_add_to_cart' : '' ) . ' add_to_cart_button' ),
					esc_attr( $product->get_id() ),
					esc_attr( $product->get_sku() ),
					esc_attr( $product->add_to_cart_text() ),
					esc_html( $product->add_to_cart_text() )
				),
				$product
			);
			?>
		</div>
	</div>
</article>
