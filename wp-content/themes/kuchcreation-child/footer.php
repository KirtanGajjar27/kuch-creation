<?php
/**
 * Custom site footer — closes <main> opened in header.php.
 */

$jewellery_term = get_term_by( 'slug', 'jewellery', 'product_cat' );
$hair_term      = get_term_by( 'slug', 'hair-accessories', 'product_cat' );
?>
</main>

<footer class="kc-footer">
	<div class="kc-container">
		<div class="kc-footer__grid">
			<div class="kc-footer__brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="kc-logo">
					<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
						<span class="kc-logo__text"><?php bloginfo( 'name' ); ?></span>
					<?php endif; ?>
				</a>
				<p class="kc-small kc-muted"><?php esc_html_e( 'Handmade jewellery and hair accessories, made in small batches in the mirror-work tradition of Kutch.', 'kuchcreation' ); ?></p>
				<div class="kc-footer__social">
					<a href="#" class="kc-icon-btn" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg></a>
					<a href="#" class="kc-icon-btn" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M14 9h3V6h-3c-1.7 0-3 1.3-3 3v2H8v3h3v7h3v-7h3l1-3h-4V9c0-.3.2-.5.5-.5H14V9Z"/></svg></a>
					<a href="#" class="kc-icon-btn" aria-label="Pinterest"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><path d="M9.5 17c1-3.5 1.5-5.5 1.5-5.5m0 0c-.5-1 .1-3 1.8-3 1.4 0 2.2 1 2.2 2.4 0 1.5-.9 3.6-1.4 4.5-.4.8.2 1.6 1.1 1.6 1.7 0 3-2 3-4.4 0-2.3-1.6-4-4.2-4-2.9 0-4.6 2.1-4.6 4.3 0 .8.3 1.7.7 2.2"/></svg></a>
				</div>
			</div>

			<nav class="kc-footer__col" aria-label="<?php esc_attr_e( 'Shop', 'kuchcreation' ); ?>">
				<h3 class="kc-caption"><?php esc_html_e( 'Shop', 'kuchcreation' ); ?></h3>
				<ul>
					<li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'All Products', 'kuchcreation' ); ?></a></li>
					<?php if ( $jewellery_term && ! is_wp_error( $jewellery_term ) ) : ?>
						<li><a href="<?php echo esc_url( get_term_link( $jewellery_term ) ); ?>"><?php echo esc_html( $jewellery_term->name ); ?></a></li>
					<?php endif; ?>
					<?php if ( $hair_term && ! is_wp_error( $hair_term ) ) : ?>
						<li><a href="<?php echo esc_url( get_term_link( $hair_term ) ); ?>"><?php echo esc_html( $hair_term->name ); ?></a></li>
					<?php endif; ?>
					<li><a href="<?php echo esc_url( home_url( '/?orderby=popularity&post_type=product' ) ); ?>"><?php esc_html_e( 'Best Sellers', 'kuchcreation' ); ?></a></li>
				</ul>
			</nav>

			<nav class="kc-footer__col" aria-label="<?php esc_attr_e( 'Company', 'kuchcreation' ); ?>">
				<h3 class="kc-caption"><?php esc_html_e( 'Company', 'kuchcreation' ); ?></h3>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php esc_html_e( 'About Us', 'kuchcreation' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'kuchcreation' ); ?></a></li>
				</ul>
			</nav>

			<nav class="kc-footer__col" aria-label="<?php esc_attr_e( 'Support', 'kuchcreation' ); ?>">
				<h3 class="kc-caption"><?php esc_html_e( 'Support', 'kuchcreation' ); ?></h3>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/shipping-delivery/' ) ); ?>"><?php esc_html_e( 'Shipping & Delivery', 'kuchcreation' ); ?></a></li>
					<li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Track Order', 'kuchcreation' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'kuchcreation' ); ?></a></li>
				</ul>
			</nav>

			<nav class="kc-footer__col" aria-label="<?php esc_attr_e( 'Legal', 'kuchcreation' ); ?>">
				<h3 class="kc-caption"><?php esc_html_e( 'Legal', 'kuchcreation' ); ?></h3>
				<ul>
					<li><a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy Policy', 'kuchcreation' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>"><?php esc_html_e( 'Terms & Conditions', 'kuchcreation' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/refund_returns/' ) ); ?>"><?php esc_html_e( 'Refund Policy', 'kuchcreation' ); ?></a></li>
				</ul>
			</nav>
		</div>

		<div class="kc-footer__bottom">
			<p class="kc-small kc-muted">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'kuchcreation' ); ?></p>
			<div class="kc-footer__payments kc-small kc-muted" aria-label="<?php esc_attr_e( 'Accepted payment methods', 'kuchcreation' ); ?>">
				<span>UPI</span><span>Cards</span><span>Net Banking</span><span>COD</span>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
