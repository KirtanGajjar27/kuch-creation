<?php
/**
 * 404 — branded instead of falling back to Avada's default, with a real
 * product grid (not a dead end) so a lost visitor can still shop.
 */
get_header();

$products = wc_get_products( [ 'status' => 'publish', 'limit' => 4, 'orderby' => 'date', 'order' => 'DESC' ] );
?>
<div class="kc-container kc-shop kc-404">
	<div class="kc-shop__empty">
		<p class="kc-caption"><?php esc_html_e( '404', 'kuchcreation' ); ?></p>
		<h1 class="kc-h1"><?php esc_html_e( "We couldn't find that page.", 'kuchcreation' ); ?></h1>
		<p class="kc-muted"><?php esc_html_e( "It may have been moved, or the link might be out of date. Here's what's new in the shop instead.", 'kuchcreation' ); ?></p>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="kc-btn kc-btn-primary"><?php esc_html_e( 'Browse All Products', 'kuchcreation' ); ?></a>
	</div>

	<?php if ( ! empty( $products ) ) : ?>
		<div class="kc-product-grid kc-404__grid">
			<?php foreach ( $products as $product ) : ?>
				<?php get_template_part( 'template-parts/product/card', null, [ 'product' => $product ] ); ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
