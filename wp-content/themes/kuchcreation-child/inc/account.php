<?php
/**
 * Registration captures real customer data (name, phone) instead of just an
 * email — stored on the user account itself and mirrored into the standard
 * WooCommerce billing_* meta keys, so it also pre-fills checkout later.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function kc_registration_fields() {
	?>
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="kc_first_name"><?php esc_html_e( 'First name', 'kuchcreation' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="kc_first_name" id="kc_first_name" autocomplete="given-name" value="<?php echo ( ! empty( $_POST['kc_first_name'] ) ) ? esc_attr( wp_unslash( $_POST['kc_first_name'] ) ) : ''; ?>" required aria-required="true" /><?php // phpcs:ignore ?>
	</p>
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="kc_last_name"><?php esc_html_e( 'Last name', 'kuchcreation' ); ?></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="kc_last_name" id="kc_last_name" autocomplete="family-name" value="<?php echo ( ! empty( $_POST['kc_last_name'] ) ) ? esc_attr( wp_unslash( $_POST['kc_last_name'] ) ) : ''; ?>" /><?php // phpcs:ignore ?>
	</p>
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="kc_phone"><?php esc_html_e( 'Phone number', 'kuchcreation' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
		<input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="kc_phone" id="kc_phone" autocomplete="tel" value="<?php echo ( ! empty( $_POST['kc_phone'] ) ) ? esc_attr( wp_unslash( $_POST['kc_phone'] ) ) : ''; ?>" required aria-required="true" /><?php // phpcs:ignore ?>
	</p>
	<?php
}
add_action( 'woocommerce_register_form', 'kc_registration_fields' );

function kc_registration_validation( $errors, $username, $email ) {
	if ( empty( $_POST['kc_first_name'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$errors->add( 'kc_first_name_error', __( 'Please enter your first name.', 'kuchcreation' ) );
	}
	if ( empty( $_POST['kc_phone'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$errors->add( 'kc_phone_error', __( 'Please enter a phone number.', 'kuchcreation' ) );
	} elseif ( ! preg_match( '/^[0-9+\-\s()]{7,20}$/', wp_unslash( $_POST['kc_phone'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$errors->add( 'kc_phone_format_error', __( 'Please enter a valid phone number.', 'kuchcreation' ) );
	}
	return $errors;
}
add_filter( 'woocommerce_registration_errors', 'kc_registration_validation', 10, 3 );

function kc_save_registration_fields( $customer_id ) {
	if ( empty( $_POST['kc_first_name'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return;
	}

	$first_name = sanitize_text_field( wp_unslash( $_POST['kc_first_name'] ) );
	$last_name  = isset( $_POST['kc_last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['kc_last_name'] ) ) : '';
	$phone      = isset( $_POST['kc_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['kc_phone'] ) ) : '';

	wp_update_user(
		[
			'ID'         => $customer_id,
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'display_name' => trim( "$first_name $last_name" ) ?: null,
		]
	);

	update_user_meta( $customer_id, 'billing_first_name', $first_name );
	update_user_meta( $customer_id, 'billing_last_name', $last_name );
	update_user_meta( $customer_id, 'billing_phone', $phone );
}
add_action( 'woocommerce_created_customer', 'kc_save_registration_fields' );
