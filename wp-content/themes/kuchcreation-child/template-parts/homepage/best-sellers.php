<?php
/**
 * Best Sellers — real product_tag "best-seller", not a hardcoded list.
 */
$products = wc_get_products(
	[
		'status' => 'publish',
		'limit'  => 8,
		'tag'    => [ 'best-seller' ],
	]
);

if ( empty( $products ) ) {
	return;
}
?>
<section class="kc-section kc-product-section" id="best-sellers" data-kc-reveal>
	<div class="kc-container">
		<div class="kc-section__header">
			<h2 class="kc-h2" data-kc-reveal-child><?php esc_html_e( 'Best Sellers', 'kuchcreation' ); ?></h2>
			<a href="<?php echo esc_url( get_term_link( 'best-seller', 'product_tag' ) ); ?>" class="kc-section__link" data-kc-reveal-child><?php esc_html_e( 'View All', 'kuchcreation' ); ?> &rarr;</a>
		</div>
		<div class="kc-product-grid" data-kc-reveal-child>
			<?php foreach ( $products as $product ) : ?>
				<?php get_template_part( 'template-parts/product/card', null, [ 'product' => $product ] ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
