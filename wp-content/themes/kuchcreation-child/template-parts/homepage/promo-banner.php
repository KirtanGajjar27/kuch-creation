<?php
/**
 * Editorial promotional banner, built around a real product image.
 */
$product = wc_get_product( 28 ); // Thread & Mirror Medallion Necklace Duo
$gallery = $product ? $product->get_gallery_image_ids() : [];
$image_id = $gallery[0] ?? ( $product ? $product->get_image_id() : 0 );
?>
<section class="kc-promo" data-kc-reveal>
	<div class="kc-promo__media" data-kc-reveal-child data-kc-parallax>
		<?php echo wp_get_attachment_image( $image_id, 'kc-hero', false, [ 'class' => 'kc-promo__image' ] ); // phpcs:ignore ?>
	</div>
	<div class="kc-promo__content" data-kc-reveal-child>
		<p class="kc-caption"><?php esc_html_e( 'Made to Order', 'kuchcreation' ); ?></p>
		<h2 class="kc-h1"><?php esc_html_e( 'Built for Every Celebration.', 'kuchcreation' ); ?></h2>
		<p class="kc-muted"><?php esc_html_e( 'From everyday layering pieces to statement bridal sets, every piece is hand-embroidered to order — so it arrives ready for whatever you\'re celebrating next.', 'kuchcreation' ); ?></p>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="kc-btn kc-btn-primary"><?php esc_html_e( 'Shop Jewellery', 'kuchcreation' ); ?></a>
	</div>
</section>
