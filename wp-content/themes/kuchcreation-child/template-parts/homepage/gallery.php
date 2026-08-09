<?php
/**
 * Shoppable photo grid — real product photography, each tile links to its
 * product. Not presented as a live Instagram embed since we don't have
 * API access to one; framed instead as a lookbook grid with a Follow CTA.
 */
$products = wc_get_products(
	[
		'status' => 'publish',
		'limit'  => 8,
		'orderby' => 'rand',
	]
);

if ( empty( $products ) ) {
	return;
}
?>
<section class="kc-section kc-gallery" data-kc-reveal>
	<div class="kc-container">
		<div class="kc-section__header kc-section__header--center">
			<h2 class="kc-h2" data-kc-reveal-child><?php esc_html_e( 'The Lookbook', 'kuchcreation' ); ?></h2>
			<p class="kc-muted" data-kc-reveal-child><?php esc_html_e( 'Styled shots from our studio, tagged straight to the piece.', 'kuchcreation' ); ?></p>
		</div>
		<div class="kc-gallery__grid" data-kc-reveal-child>
			<?php foreach ( $products as $product ) : ?>
				<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="kc-gallery__item">
					<?php echo $product->get_image( 'kc-category-card' ); // phpcs:ignore ?>
					<span class="kc-gallery__overlay">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4"/><path d="M3 6h18M16 10a4 4 0 0 1-8 0"/></svg>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
		<div class="kc-gallery__cta" data-kc-reveal-child>
			<a href="#" class="kc-btn kc-btn-outline"><?php esc_html_e( 'Follow Us', 'kuchcreation' ); ?></a>
		</div>
	</div>
</section>
