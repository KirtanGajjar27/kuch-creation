<?php
/**
 * Search results. Our header search form always scopes to post_type=product,
 * so this renders as a product grid using the same ProductCard component as
 * the shop page. Falls back to a simple list for any non-product result
 * (e.g. a direct ?s= URL without post_type).
 */

get_header();
?>
<div class="kc-container kc-shop">
	<header class="kc-shop__header">
		<h1 class="kc-h1">
			<?php
			printf(
				/* translators: %s: search term */
				esc_html__( 'Search results for "%s"', 'kuchcreation' ),
				esc_html( get_search_query() )
			);
			?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="kc-product-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				if ( 'product' === get_post_type() ) {
					get_template_part( 'template-parts/product/card', null, [ 'product' => wc_get_product( get_the_ID() ) ] );
				} else {
					?>
					<article class="kc-search-fallback-item">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</article>
					<?php
				}
			endwhile;
			?>
		</div>
		<div class="kc-shop__pagination">
			<?php the_posts_pagination(); ?>
		</div>
	<?php else : ?>
		<div class="kc-shop__empty">
			<p class="kc-muted"><?php esc_html_e( "We couldn't find anything for that search — try a different term.", 'kuchcreation' ); ?></p>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="kc-btn kc-btn-primary"><?php esc_html_e( 'Browse All Products', 'kuchcreation' ); ?></a>
		</div>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
