<?php
/**
 * Custom site header — replaces Avada's header markup entirely so the nav,
 * search overlay, and cart drawer are fully ours. Loaded via get_header()
 * on every page (child theme header.php takes priority over parent).
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="kc-skip-link" href="#kc-main"><?php esc_html_e( 'Skip to content', 'kuchcreation' ); ?></a>

<?php $announcement = get_theme_mod( 'kc_announcement_text', __( 'Free Shipping on Orders Above ₹999', 'kuchcreation' ) ); ?>
<div class="kc-announcement" role="note">
	<div class="kc-announcement__track">
		<span><?php echo esc_html( $announcement ); ?></span>
		<span aria-hidden="true"><?php echo esc_html( $announcement ); ?></span>
	</div>
</div>

<header class="kc-header" id="kc-header" data-kc-header>
	<div class="kc-header__inner kc-container">
		<button type="button" class="kc-nav-toggle" id="kc-nav-toggle" aria-expanded="false" aria-controls="kc-mobile-menu" aria-label="<?php esc_attr_e( 'Open menu', 'kuchcreation' ); ?>">
			<span></span><span></span><span></span>
		</button>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="kc-logo">
			<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
				<span class="kc-logo__text"><?php bloginfo( 'name' ); ?></span>
			<?php endif; ?>
		</a>

		<nav class="kc-nav" aria-label="<?php esc_attr_e( 'Primary', 'kuchcreation' ); ?>">
			<?php kc_primary_menu(); ?>
		</nav>

		<div class="kc-header__actions">
			<button type="button" class="kc-icon-btn" id="kc-search-toggle" aria-haspopup="dialog" aria-controls="kc-search-overlay" aria-label="<?php esc_attr_e( 'Search', 'kuchcreation' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
			</button>
			<a class="kc-icon-btn" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" aria-label="<?php esc_attr_e( 'Account', 'kuchcreation' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c1.5-4 4.5-6 8-6s6.5 2 8 6"/></svg>
			</a>
			<button type="button" class="kc-icon-btn kc-cart-toggle" id="kc-cart-toggle" aria-haspopup="dialog" aria-controls="kc-cart-drawer" aria-label="<?php esc_attr_e( 'Cart', 'kuchcreation' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 6h2l1.6 10.6a2 2 0 0 0 2 1.7h7.8a2 2 0 0 0 2-1.6L21 9H6"/><circle cx="10" cy="21" r="1"/><circle cx="17" cy="21" r="1"/></svg>
				<?php echo wp_kses_post( ( function () {
					ob_start();
					?><span class="kc-cart-count" id="kc-cart-count"><?php echo WC()->cart ? esc_html( WC()->cart->get_cart_contents_count() ) : '0'; ?></span><?php
					return ob_get_clean();
				} )() ); ?>
			</button>
		</div>
	</div>

	<div class="kc-mobile-menu" id="kc-mobile-menu">
		<?php kc_primary_menu( true ); ?>
	</div>
</header>

<div class="kc-search-overlay" id="kc-search-overlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search', 'kuchcreation' ); ?>" hidden>
	<button type="button" class="kc-overlay-close" id="kc-search-close" aria-label="<?php esc_attr_e( 'Close search', 'kuchcreation' ); ?>">&times;</button>
	<div class="kc-search-overlay__inner">
		<form role="search" method="get" class="kc-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label for="kc-search-input" class="kc-visually-hidden"><?php esc_html_e( 'Search products', 'kuchcreation' ); ?></label>
			<input type="search" name="s" id="kc-search-input" placeholder="<?php esc_attr_e( 'Search for necklaces, cuffs, hair accessories…', 'kuchcreation' ); ?>" autocomplete="off">
			<input type="hidden" name="post_type" value="product">
		</form>
		<p class="kc-search-overlay__hint kc-small kc-muted"><?php esc_html_e( 'Popular: Necklace, Cuff, Hair Bow, Bridal Set', 'kuchcreation' ); ?></p>
		<div class="kc-search-results" id="kc-search-results" aria-live="polite"></div>
	</div>
</div>

<div class="kc-cart-drawer" id="kc-cart-drawer" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Your cart', 'kuchcreation' ); ?>" hidden>
	<div class="kc-cart-drawer__header">
		<h2 class="kc-h4"><?php esc_html_e( 'Your Cart', 'kuchcreation' ); ?></h2>
		<button type="button" class="kc-overlay-close" id="kc-cart-close" aria-label="<?php esc_attr_e( 'Close cart', 'kuchcreation' ); ?>">&times;</button>
	</div>
	<?php get_template_part( 'template-parts/components/mini-cart' ); ?>
</div>

<?php get_template_part( 'template-parts/components/modal' ); ?>

<div class="kc-overlay-backdrop" id="kc-overlay-backdrop" hidden></div>
<div class="kc-toast" id="kc-toast" role="status" aria-live="polite"></div>

<main id="kc-main">
