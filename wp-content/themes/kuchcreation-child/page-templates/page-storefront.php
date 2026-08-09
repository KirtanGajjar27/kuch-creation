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
?>
<div class="kc-container kc-section kc-storefront-page">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<h1 class="kc-h2"><?php the_title(); ?></h1>
		<?php the_content(); ?>
	<?php endwhile; ?>
</div>
<?php
get_footer();
