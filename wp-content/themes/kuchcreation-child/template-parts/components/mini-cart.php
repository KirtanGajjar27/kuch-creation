<?php
/**
 * Mini-cart contents, rendered inside the cart drawer and re-rendered as a
 * WooCommerce cart fragment after every AJAX add/remove.
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'WC' ) ) {
	return;
}

$cart = WC()->cart;
?>

<?php if ( $cart && ! $cart->is_empty() ) : ?>
	<ul class="kc-mini-cart__items">
		<?php foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) :
			$product = $cart_item['data'];
			if ( ! $product || ! $product->exists() || $cart_item['quantity'] <= 0 ) {
				continue;
			}
			$thumbnail = $product->get_image( 'thumbnail' );
			?>
			<li class="kc-mini-cart__item">
				<a href="<?php echo esc_url( $product->get_permalink( $cart_item ) ); ?>" class="kc-mini-cart__image">
					<?php echo wp_kses_post( $thumbnail ); ?>
				</a>
				<div class="kc-mini-cart__details">
					<a href="<?php echo esc_url( $product->get_permalink( $cart_item ) ); ?>" class="kc-mini-cart__name">
						<?php echo esc_html( $product->get_name() ); ?>
					</a>
					<span class="kc-mini-cart__qty-price">
						<?php echo esc_html( $cart_item['quantity'] ); ?> &times; <?php echo wp_kses_post( wc_price( $product->get_price() ) ); ?>
					</span>
					<a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="kc-mini-cart__remove" aria-label="<?php esc_attr_e( 'Remove item', 'kuchcreation' ); ?>">
						<?php esc_html_e( 'Remove', 'kuchcreation' ); ?>
					</a>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>

	<div class="kc-mini-cart__footer">
		<div class="kc-mini-cart__subtotal">
			<span><?php esc_html_e( 'Subtotal', 'kuchcreation' ); ?></span>
			<span><?php echo wp_kses_post( $cart->get_cart_subtotal() ); ?></span>
		</div>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="kc-btn kc-btn-outline kc-mini-cart__view-cart"><?php esc_html_e( 'View Cart', 'kuchcreation' ); ?></a>
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="kc-btn kc-btn-primary kc-mini-cart__checkout"><?php esc_html_e( 'Checkout', 'kuchcreation' ); ?></a>
	</div>
<?php else : ?>
	<div class="kc-mini-cart__empty">
		<p><?php esc_html_e( 'Your cart is empty.', 'kuchcreation' ); ?></p>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="kc-btn kc-btn-primary"><?php esc_html_e( 'Start Shopping', 'kuchcreation' ); ?></a>
	</div>
<?php endif; ?>
