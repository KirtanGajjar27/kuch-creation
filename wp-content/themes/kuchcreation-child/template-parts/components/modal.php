<?php
/**
 * Generic modal shell, reused for Quick View. Content is injected via JS.
 */
?>
<div class="kc-modal" id="kc-quick-view-modal" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Quick view', 'kuchcreation' ); ?>" hidden>
	<button type="button" class="kc-overlay-close" id="kc-quick-view-close" aria-label="<?php esc_attr_e( 'Close', 'kuchcreation' ); ?>">&times;</button>
	<div class="kc-modal__content" id="kc-quick-view-content">
		<div class="kc-modal__loading"><?php esc_html_e( 'Loading…', 'kuchcreation' ); ?></div>
	</div>
</div>
