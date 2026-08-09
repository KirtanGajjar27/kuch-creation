<?php
/**
 * CategoryCard component. Usage:
 *   get_template_part( 'template-parts/components/category-card', null, [ 'term' => $term ] );
 */

if ( ! isset( $args['term'] ) || ! ( $args['term'] instanceof WP_Term ) ) {
	return;
}

$term        = $args['term'];
$thumb_id    = get_term_meta( $term->term_id, 'thumbnail_id', true );
$image_url   = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'kc-category-card' ) : wc_placeholder_img_src( 'kc-category-card' );
?>
<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="kc-category-card">
	<span class="kc-category-card__image-wrap">
		<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $term->name ); ?>" class="kc-category-card__image" loading="lazy">
	</span>
	<span class="kc-category-card__label">
		<span class="kc-category-card__name"><?php echo esc_html( $term->name ); ?></span>
		<span class="kc-category-card__arrow" aria-hidden="true">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
		</span>
	</span>
</a>
