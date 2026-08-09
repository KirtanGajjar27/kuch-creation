<?php
/**
 * Newsletter — submits via AJAX to a real subscriber CPT (inc/newsletter.php).
 */
?>
<section class="kc-section kc-newsletter" data-kc-reveal>
	<div class="kc-container kc-newsletter__inner">
		<h2 class="kc-h2" data-kc-reveal-child><?php esc_html_e( 'Stay in the Loop.', 'kuchcreation' ); ?></h2>
		<p class="kc-muted" data-kc-reveal-child><?php esc_html_e( 'Get early access to new pieces, small-batch drops, and festive collections.', 'kuchcreation' ); ?></p>
		<form class="kc-newsletter__form" id="kc-newsletter-form" data-kc-reveal-child novalidate>
			<label class="kc-visually-hidden" for="kc-newsletter-email"><?php esc_html_e( 'Email address', 'kuchcreation' ); ?></label>
			<input type="email" id="kc-newsletter-email" name="email" required placeholder="<?php esc_attr_e( 'Your email address', 'kuchcreation' ); ?>">
			<button type="submit" class="kc-btn kc-btn-primary"><?php esc_html_e( 'Subscribe', 'kuchcreation' ); ?></button>
			<?php wp_nonce_field( 'kc_newsletter', 'kc_newsletter_nonce' ); ?>
		</form>
		<p class="kc-newsletter__message kc-small" id="kc-newsletter-message" role="status" aria-live="polite"></p>
	</div>
</section>
