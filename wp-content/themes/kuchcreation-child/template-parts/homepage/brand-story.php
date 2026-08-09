<?php
/**
 * Brand Story — editorial image + text.
 */
$product  = wc_get_product( 29 ); // Meera Pearl-Tassel Necklace
$gallery  = $product ? $product->get_gallery_image_ids() : [];
$image_id = $gallery[0] ?? ( $product ? $product->get_image_id() : 0 );
?>
<section class="kc-section kc-brand-story" data-kc-reveal>
	<div class="kc-container kc-brand-story__grid">
		<div class="kc-brand-story__media" data-kc-reveal-child>
			<?php echo wp_get_attachment_image( $image_id, 'kc-category-card', false, [ 'class' => 'kc-brand-story__image' ] ); // phpcs:ignore ?>
		</div>
		<div class="kc-brand-story__content" data-kc-reveal-child>
			<p class="kc-caption"><?php esc_html_e( 'Our Philosophy', 'kuchcreation' ); ?></p>
			<h2 class="kc-h2"><?php esc_html_e( 'Quality should never be complicated.', 'kuchcreation' ); ?></h2>
			<p class="kc-muted">
				<?php esc_html_e( 'Kuch Creation began as a small collection of pieces inspired by the mirror-work and thread embroidery traditions of Kutch, Gujarat. Every piece is made by hand in small batches — colours, mirror placement and finishing vary slightly from piece to piece, and we consider that part of the craft, not a flaw.', 'kuchcreation' ); ?>
			</p>
			<a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>" class="kc-btn kc-btn-outline"><?php esc_html_e( 'Discover Our Story', 'kuchcreation' ); ?></a>
		</div>
	</div>
</section>
