<?php
/**
 * Homepage. Every section pulls real WooCommerce data — no hardcoded
 * products or categories. See template-parts/homepage/ for each section.
 */

get_header();
?>

<?php get_template_part( 'template-parts/homepage/hero' ); ?>
<?php get_template_part( 'template-parts/homepage/categories' ); ?>
<?php get_template_part( 'template-parts/homepage/featured-products' ); ?>
<?php get_template_part( 'template-parts/homepage/new-arrivals' ); ?>
<?php get_template_part( 'template-parts/homepage/promo-banner' ); ?>
<?php get_template_part( 'template-parts/homepage/best-sellers' ); ?>
<?php get_template_part( 'template-parts/homepage/brand-story' ); ?>
<?php get_template_part( 'template-parts/homepage/why-choose-us' ); ?>
<?php get_template_part( 'template-parts/homepage/testimonials' ); ?>
<?php get_template_part( 'template-parts/homepage/gallery' ); ?>
<?php get_template_part( 'template-parts/homepage/newsletter' ); ?>

<?php get_footer(); ?>
