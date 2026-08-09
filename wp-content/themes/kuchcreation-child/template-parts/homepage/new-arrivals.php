<?php
/**
 * New Arrivals — most recently published products, horizontally scrollable.
 */
$products = wc_get_products(
	[
		'status'  => 'publish',
		'limit'   => 10,
		'orderby' => 'date',
		'order'   => 'DESC',
	]
);

if ( empty( $products ) ) {
	return;
}
?>
<section class="kc-section kc-new-arrivals" data-kc-reveal>
	<div class="kc-container">
		<div class="kc-section__header">
			<h2 class="kc-h2" data-kc-reveal-child><?php esc_html_e( 'New Arrivals', 'kuchcreation' ); ?></h2>
			<div class="kc-carousel-controls" data-kc-reveal-child>
				<button type="button" class="kc-carousel-arrow" data-carousel-prev="kc-new-arrivals-track" aria-label="<?php esc_attr_e( 'Scroll left', 'kuchcreation' ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M15 6l-6 6 6 6"/></svg>
				</button>
				<button type="button" class="kc-carousel-arrow" data-carousel-next="kc-new-arrivals-track" aria-label="<?php esc_attr_e( 'Scroll right', 'kuchcreation' ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M9 6l6 6-6 6"/></svg>
				</button>
			</div>
		</div>
		<div class="kc-carousel" id="kc-new-arrivals-track" data-kc-reveal-child>
			<?php foreach ( $products as $product ) : ?>
				<div class="kc-carousel__item">
					<?php get_template_part( 'template-parts/product/card', null, [ 'product' => $product ] ); ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
