<?php
/**
 * Why Choose Us — 4 value props, tied to real store policies (COD/UPI live
 * on this store, refund policy page exists).
 */
$features = [
	[
		'title' => __( 'Handmade with Care', 'kuchcreation' ),
		'text'  => __( 'Every piece is hand-embroidered, not mass-produced — small imperfections are part of the craft.', 'kuchcreation' ),
		'icon'  => '<path d="M12 21s-7-4.5-9-9c-1.5-3.3.3-6.5 3.3-7 2-.3 3.7.6 4.7 2 .1.1.2.1.3.2C11.4 6.1 13 5.2 15 5.5c3 .5 4.8 3.7 3.3 7-2 4.5-9 9-9 9-.4-.2-.8-.4-1.3-.7Z"/>',
	],
	[
		'title' => __( 'Small-Batch Craftsmanship', 'kuchcreation' ),
		'text'  => __( 'Pieces are made to order in limited quantities, so what you buy stays a little rare.', 'kuchcreation' ),
		'icon'  => '<rect x="4" y="4" width="16" height="16" rx="2"/><path d="M4 10h16M10 4v16"/>',
	],
	[
		'title' => __( 'Secure Payments', 'kuchcreation' ),
		'text'  => __( 'Pay by UPI, card, net banking, or cash on delivery — every transaction is encrypted.', 'kuchcreation' ),
		'icon'  => '<rect x="3" y="6" width="18" height="13" rx="2"/><path d="M3 10h18M7 15h4"/>',
	],
	[
		'title' => __( 'Easy Returns', 'kuchcreation' ),
		'text'  => __( 'Not the right fit? Check our Refund & Returns Policy for a straightforward process.', 'kuchcreation' ),
		'icon'  => '<path d="M4 4v6h6M4.5 15a8 8 0 1 0 2-8.5L4 10"/>',
	],
];
?>
<section class="kc-section kc-why-us" data-kc-reveal>
	<div class="kc-container">
		<div class="kc-why-us__grid">
			<?php foreach ( $features as $feature ) : ?>
				<div class="kc-why-us__item" data-kc-reveal-child>
					<span class="kc-why-us__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><?php echo $feature['icon']; // phpcs:ignore ?></svg>
					</span>
					<h3 class="kc-h4"><?php echo esc_html( $feature['title'] ); ?></h3>
					<p class="kc-small kc-muted"><?php echo esc_html( $feature['text'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
