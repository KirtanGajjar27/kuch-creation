<?php
/**
 * Login/Register — overrides WooCommerce's default two-column template with
 * a tabbed split-screen layout. All field names, nonces, and hooks are kept
 * identical to WooCommerce core's own form-login.php so the auth handlers
 * (wp_signon, WC_Form_Handler::process_login/process_registration) work
 * exactly as WooCommerce expects — only the surrounding markup changed.
 *
 * @see wp-content/plugins/woocommerce/templates/myaccount/form-login.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$registration_open = 'yes' === get_option( 'woocommerce_enable_myaccount_registration' );
$start_on_register  = isset( $_GET['register'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

$panel_product = wc_get_product( 29 ); // Meera Pearl-Tassel Necklace
$panel_gallery = $panel_product ? $panel_product->get_gallery_image_ids() : [];
$panel_image_id = $panel_gallery[0] ?? ( $panel_product ? $panel_product->get_image_id() : 0 );

do_action( 'woocommerce_before_customer_login_form' );
?>

<div class="kc-auth">
	<div class="kc-auth__media">
		<?php echo wp_get_attachment_image( $panel_image_id, 'kc-hero', false, [ 'class' => 'kc-auth__image' ] ); // phpcs:ignore ?>
		<div class="kc-auth__media-copy">
			<p class="kc-caption">Kuch Creation</p>
			<p class="kc-h3">Handmade jewellery, made to feel like yours.</p>
			<ul class="kc-auth__perks">
				<li>Track orders and delivery status</li>
				<li>Save your address for faster checkout</li>
				<li>Get early access to new small-batch drops</li>
			</ul>
		</div>
	</div>

	<div class="kc-auth__panel">
		<div class="kc-auth__panel-inner">

			<?php if ( $registration_open ) : ?>
				<div class="kc-auth__tabs" role="tablist">
					<button type="button" role="tab" class="kc-auth__tab<?php echo $start_on_register ? '' : ' is-active'; ?>" id="kc-tab-login" aria-controls="kc-panel-login" aria-selected="<?php echo $start_on_register ? 'false' : 'true'; ?>" data-kc-auth-tab="login">
						<?php esc_html_e( 'Log In', 'kuchcreation' ); ?>
					</button>
					<button type="button" role="tab" class="kc-auth__tab<?php echo $start_on_register ? ' is-active' : ''; ?>" id="kc-tab-register" aria-controls="kc-panel-register" aria-selected="<?php echo $start_on_register ? 'true' : 'false'; ?>" data-kc-auth-tab="register">
						<?php esc_html_e( 'Create Account', 'kuchcreation' ); ?>
					</button>
				</div>
			<?php endif; ?>

			<div class="kc-auth__form-wrap" id="kc-panel-login" role="tabpanel" aria-labelledby="kc-tab-login" <?php echo ( $registration_open && $start_on_register ) ? 'hidden' : ''; ?>>
				<h1 class="kc-h3"><?php esc_html_e( 'Welcome back', 'kuchcreation' ); ?></h1>
				<p class="kc-muted kc-small"><?php esc_html_e( 'Log in to view your orders and saved details.', 'kuchcreation' ); ?></p>

				<form class="woocommerce-form woocommerce-form-login login kc-auth-form" method="post" novalidate>
					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required aria-required="true" /><?php // phpcs:ignore ?>
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide kc-password-row">
						<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
						<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
						<button type="button" class="kc-password-toggle" data-kc-toggle-password="password" aria-label="<?php esc_attr_e( 'Show password', 'kuchcreation' ); ?>">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
						</button>
					</p>

					<?php do_action( 'woocommerce_login_form' ); ?>

					<p class="form-row kc-auth-form__footer">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
						</label>
						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
						<button type="submit" class="kc-btn kc-btn-primary woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log In', 'kuchcreation' ); ?></button>
					</p>
					<p class="woocommerce-LostPassword lost_password">
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
					</p>

					<?php do_action( 'woocommerce_login_form_end' ); ?>
				</form>
			</div>

			<?php if ( $registration_open ) : ?>
				<div class="kc-auth__form-wrap" id="kc-panel-register" role="tabpanel" aria-labelledby="kc-tab-register" <?php echo $start_on_register ? '' : 'hidden'; ?>>
					<h1 class="kc-h3"><?php esc_html_e( 'Create your account', 'kuchcreation' ); ?></h1>
					<p class="kc-muted kc-small"><?php esc_html_e( 'Takes less than a minute — no password to remember, we\'ll email you a secure link.', 'kuchcreation' ); ?></p>

					<form method="post" class="woocommerce-form woocommerce-form-register register kc-auth-form" <?php do_action( 'woocommerce_register_form_tag' ); ?>>
						<?php do_action( 'woocommerce_register_form_start' ); ?>

						<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required aria-required="true" /><?php // phpcs:ignore ?>
							</p>
						<?php endif; ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
							<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required aria-required="true" /><?php // phpcs:ignore ?>
						</p>

						<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide kc-password-row">
								<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
								<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required aria-required="true" />
								<button type="button" class="kc-password-toggle" data-kc-toggle-password="reg_password" aria-label="<?php esc_attr_e( 'Show password', 'kuchcreation' ); ?>">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
								</button>
							</p>
						<?php else : ?>
							<p class="kc-small kc-muted"><?php esc_html_e( "We'll email you a link to set your password.", 'woocommerce' ); ?></p>
						<?php endif; ?>

						<?php do_action( 'woocommerce_register_form' ); ?>

						<p class="woocommerce-form-row form-row kc-auth-form__footer">
							<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
							<button type="submit" class="kc-btn kc-btn-primary woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Create Account', 'kuchcreation' ); ?></button>
						</p>

						<?php do_action( 'woocommerce_register_form_end' ); ?>
					</form>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
