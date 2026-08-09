<?php
/**
 * Featured Products — real WooCommerce "featured" flag, no hardcoded list.
 */
$products = wc_get_products(
	[
		'status'   => 'publish',
		'limit'    => 8,
		'featured' => true,
	]
);

if ( empty( $products ) ) {
	return;
}
?>
<section class="kc-section kc-product-section" data-kc-reveal>
	<div class="kc-container">
		<div class="kc-section__header">
			<h2 class="kc-h2" data-kc-reveal-child><?php esc_html_e( 'Featured Pieces', 'kuchcreation' ); ?></h2>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="kc-section__link" data-kc-reveal-child><?php esc_html_e( 'View All', 'kuchcreation' ); ?> &rarr;</a>
		</div>
		<div class="kc-product-grid" data-kc-reveal-child>
			<?php foreach ( $products as $product ) : ?>
				<?php get_template_part( 'template-parts/product/card', null, [ 'product' => $product ] ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
