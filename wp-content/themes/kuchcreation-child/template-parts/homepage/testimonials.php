<?php
/**
 * Testimonials — pulled from real, approved WooCommerce product reviews.
 * No reviews exist yet on a brand-new store, so this renders an honest
 * empty state rather than fabricated quotes.
 */
$reviews = get_comments(
	[
		'status'  => 'approve',
		'type'    => 'review',
		'number'  => 6,
		'post_status' => 'publish',
	]
);
?>
<section class="kc-section kc-testimonials" data-kc-reveal>
	<div class="kc-container">
		<div class="kc-section__header kc-section__header--center">
			<h2 class="kc-h2" data-kc-reveal-child><?php esc_html_e( 'What Customers Say', 'kuchcreation' ); ?></h2>
		</div>

		<?php if ( ! empty( $reviews ) ) : ?>
			<div class="kc-testimonials__grid" data-kc-reveal-child>
				<?php foreach ( $reviews as $review ) :
					$rating = get_comment_meta( $review->comment_ID, 'rating', true );
					$product = wc_get_product( $review->comment_post_ID );
					?>
					<blockquote class="kc-testimonial">
						<div class="kc-product-card__rating"><?php echo wc_get_rating_html( (float) $rating ); // phpcs:ignore ?></div>
						<p><?php echo esc_html( wp_trim_words( $review->comment_content, 30 ) ); ?></p>
						<footer>
							<span class="kc-testimonial__name"><?php echo esc_html( $review->comment_author ); ?></span>
							<?php if ( $product ) : ?>
								<span class="kc-small kc-muted">&mdash; <?php echo esc_html( $product->get_name() ); ?></span>
							<?php endif; ?>
						</footer>
					</blockquote>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<div class="kc-testimonials__empty" data-kc-reveal-child>
				<p class="kc-muted"><?php esc_html_e( "We're brand new — reviews will start appearing here as soon as customers share them.", 'kuchcreation' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>
