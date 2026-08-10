<?php
/**
 * Template Name: Storefront (No Builder Chrome)
 *
 * Minimal wrapper for WooCommerce-owned pages (Cart, Checkout, My Account) —
 * skips Avada/Fusion's page chrome entirely so the default WooCommerce
 * shortcode output can be styled cleanly via CSS alone. Assigned to those
 * pages via wp-cli, not meant to be picked for ordinary content pages.
 */

get_header();

// The logged-out My Account view (login/register) renders its own split-
// screen layout with its own contextual heading — the generic page title
// would just be a redundant second H1 above it.
$kc_show_page_title = ! ( is_account_page() && ! is_user_logged_in() );
?>
<div class="kc-container kc-section kc-storefront-page">
	<?php
	while ( have_posts() ) :
		the_post();
		if ( $kc_show_page_title ) :
			?>
			<h1 class="kc-h2"><?php the_title(); ?></h1>
			<?php
		endif;
		the_content();
	endwhile;
	?>
</div>
<?php
get_footer();
