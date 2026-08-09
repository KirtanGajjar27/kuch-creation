<?php
/**
 * Single product page. Uses WooCommerce's own action hooks for the summary
 * column (title, price, variations/add-to-cart, meta) so variable products,
 * stock rules, and add-to-cart all keep working exactly as WooCommerce
 * expects — only the surrounding two-column layout and tab/related sections
 * are ours.
 */

get_header();

while ( have_posts() ) :
	the_post();
	global $product;
	if ( ! $product instanceof WC_Product ) {
		$product = wc_get_product( get_the_ID() );
	}
	?>
	<div class="kc-container kc-product-page">
		<nav class="kc-breadcrumb kc-small kc-muted">
			<?php woocommerce_breadcrumb(); ?>
		</nav>

		<div class="kc-product-page__grid">
			<div class="kc-product-page__gallery">
				<?php woocommerce_show_product_images(); ?>
			</div>

			<div class="kc-product-page__summary">
				<?php do_action( 'woocommerce_single_product_summary' ); ?>
			</div>
		</div>

		<div class="kc-product-page__tabs">
			<?php woocommerce_output_product_data_tabs(); ?>
		</div>

		<div class="kc-product-page__related">
			<?php woocommerce_output_related_products(); ?>
		</div>
	</div>
	<?php
endwhile;

get_footer();
