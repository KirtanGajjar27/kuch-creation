<?php
/**
 * Shop + product category archive. WooCommerce's own query, sorting,
 * pagination and price-filter query vars all still apply — only the
 * markup is ours (ProductCard component instead of content-product.php).
 */

get_header();

$current_term = is_product_category() ? get_queried_object() : null;
$categories   = get_terms( [ 'taxonomy' => 'product_cat', 'hide_empty' => true ] );
?>

<div class="kc-container kc-shop">
	<nav class="kc-breadcrumb kc-small kc-muted">
		<?php woocommerce_breadcrumb(); ?>
	</nav>

	<header class="kc-shop__header">
		<h1 class="kc-h1"><?php echo $current_term ? esc_html( $current_term->name ) : esc_html__( 'Shop', 'kuchcreation' ); ?></h1>
		<?php if ( $current_term && $current_term->description ) : ?>
			<p class="kc-muted"><?php echo esc_html( $current_term->description ); ?></p>
		<?php endif; ?>
	</header>

	<div class="kc-shop__layout">
		<aside class="kc-shop__sidebar">
			<div class="kc-filter-block">
				<h3 class="kc-caption"><?php esc_html_e( 'Category', 'kuchcreation' ); ?></h3>
				<ul class="kc-filter-list">
					<li class="<?php echo ! $current_term ? 'is-active' : ''; ?>">
						<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'All Products', 'kuchcreation' ); ?></a>
					</li>
					<?php foreach ( $categories as $term ) : ?>
						<li class="<?php echo ( $current_term && $current_term->term_id === $term->term_id ) ? 'is-active' : ''; ?>">
							<a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?> <span class="kc-muted">(<?php echo esc_html( $term->count ); ?>)</span></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="kc-filter-block">
				<h3 class="kc-caption"><?php esc_html_e( 'Price', 'kuchcreation' ); ?></h3>
				<form class="kc-price-filter" method="get">
					<?php
					// Preserve any existing query vars (category browsing, etc.).
					foreach ( $_GET as $key => $value ) { // phpcs:ignore
						if ( in_array( $key, [ 'min_price', 'max_price' ], true ) ) {
							continue;
						}
						printf( '<input type="hidden" name="%s" value="%s">', esc_attr( $key ), esc_attr( $value ) );
					}
					$min = isset( $_GET['min_price'] ) ? absint( $_GET['min_price'] ) : ''; // phpcs:ignore
					$max = isset( $_GET['max_price'] ) ? absint( $_GET['max_price'] ) : ''; // phpcs:ignore
					?>
					<div class="kc-price-filter__row">
						<input type="number" name="min_price" placeholder="<?php esc_attr_e( 'Min', 'kuchcreation' ); ?>" value="<?php echo esc_attr( $min ); ?>" min="0">
						<span>&ndash;</span>
						<input type="number" name="max_price" placeholder="<?php esc_attr_e( 'Max', 'kuchcreation' ); ?>" value="<?php echo esc_attr( $max ); ?>" min="0">
					</div>
					<button type="submit" class="kc-btn kc-btn-outline kc-price-filter__submit"><?php esc_html_e( 'Apply', 'kuchcreation' ); ?></button>
				</form>
			</div>
		</aside>

		<div class="kc-shop__main">
			<div class="kc-shop__toolbar">
				<button type="button" class="kc-btn kc-btn-outline kc-shop__filter-toggle" id="kc-shop-filter-toggle"><?php esc_html_e( 'Filters', 'kuchcreation' ); ?></button>
				<p class="kc-shop__count kc-small kc-muted"><?php woocommerce_result_count(); ?></p>
				<div class="kc-shop__sort"><?php woocommerce_catalog_ordering(); ?></div>
			</div>

			<?php if ( woocommerce_product_loop() ) : ?>
				<div class="kc-product-grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/product/card', null, [ 'product' => wc_get_product( get_the_ID() ) ] ); ?>
					<?php endwhile; ?>
				</div>
				<div class="kc-shop__pagination">
					<?php woocommerce_pagination(); ?>
				</div>
			<?php else : ?>
				<div class="kc-shop__empty">
					<p class="kc-muted"><?php esc_html_e( 'No products found in this range yet — try widening your filters.', 'kuchcreation' ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
