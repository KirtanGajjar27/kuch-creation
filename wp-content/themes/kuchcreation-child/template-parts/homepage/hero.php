<?php
/**
 * Hero. Image comes from a real product (Kundan Bridal Set) rather than a
 * stock/placeholder image.
 */
$hero_product = wc_get_product( 37 );
$hero_image   = $hero_product ? $hero_product->get_image( 'kc-hero', [ 'class' => 'kc-hero__image' ] ) : '';
$best_seller_term = get_term_by( 'slug', 'best-seller', 'product_tag' );
?>
<section class="kc-hero" data-kc-reveal>
	<div class="kc-container kc-hero__grid">
		<div class="kc-hero__content">
			<p class="kc-caption" data-kc-reveal-child><?php esc_html_e( 'Handmade in Small Batches', 'kuchcreation' ); ?></p>
			<h1 class="kc-display" data-kc-reveal-child><?php esc_html_e( 'Crafted in the Mirror-Work Tradition of Kutch.', 'kuchcreation' ); ?></h1>
			<p class="kc-hero__sub kc-muted" data-kc-reveal-child>
				<?php esc_html_e( 'Thread-embroidered necklaces, cuffs and hair accessories, hand-finished with mirror work, cowrie shells and oxidised silver — made to order, one small batch at a time.', 'kuchcreation' ); ?>
			</p>
			<div class="kc-hero__actions" data-kc-reveal-child>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="kc-btn kc-btn-primary"><?php esc_html_e( 'Shop Collection', 'kuchcreation' ); ?></a>
				<?php if ( $best_seller_term && ! is_wp_error( $best_seller_term ) ) : ?>
					<a href="<?php echo esc_url( get_term_link( $best_seller_term ) ); ?>" class="kc-btn kc-btn-outline"><?php esc_html_e( 'Explore Best Sellers', 'kuchcreation' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
		<div class="kc-hero__media" data-kc-reveal-child>
			<?php echo wp_kses_post( $hero_image ); ?>
		</div>
	</div>
</section>
