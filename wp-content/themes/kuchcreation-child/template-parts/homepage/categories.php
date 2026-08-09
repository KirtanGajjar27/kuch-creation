<?php
/**
 * Featured Categories — only real categories that currently hold published
 * products are shown, so we never link into an empty archive.
 */
$categories = get_terms(
	[
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'exclude'    => [ get_option( 'default_product_cat', 0 ) ],
	]
);

if ( empty( $categories ) || is_wp_error( $categories ) ) {
	return;
}
?>
<section class="kc-section kc-categories" data-kc-reveal>
	<div class="kc-container">
		<div class="kc-section__header">
			<h2 class="kc-h2" data-kc-reveal-child><?php esc_html_e( 'Shop by Category', 'kuchcreation' ); ?></h2>
		</div>
		<div class="kc-categories__grid" data-kc-reveal-child>
			<?php foreach ( $categories as $term ) : ?>
				<?php get_template_part( 'template-parts/components/category-card', null, [ 'term' => $term ] ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
