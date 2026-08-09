<?php
/**
 * Newsletter capture: a private CPT stores signups so the form is
 * genuinely functional (exportable later / connectable to an ESP) instead
 * of a decorative form that does nothing on submit.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function kc_register_subscriber_cpt() {
	register_post_type(
		'kc_subscriber',
		[
			'label'        => __( 'Newsletter Subscribers', 'kuchcreation' ),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => 'tools.php',
			'supports'     => [ 'title' ],
			'capabilities' => [ 'create_posts' => 'do_not_allow' ],
			'map_meta_cap' => true,
		]
	);
}
add_action( 'init', 'kc_register_subscriber_cpt' );

function kc_ajax_newsletter_signup() {
	check_ajax_referer( 'kc_newsletter', 'nonce' );

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

	if ( ! is_email( $email ) ) {
		wp_send_json_error( [ 'message' => __( 'Please enter a valid email address.', 'kuchcreation' ) ] );
	}

	$existing = get_posts(
		[
			'post_type'      => 'kc_subscriber',
			'title'          => $email,
			'posts_per_page' => 1,
			'fields'         => 'ids',
		]
	);

	if ( ! empty( $existing ) ) {
		wp_send_json_success( [ 'message' => __( "You're already on the list!", 'kuchcreation' ) ] );
	}

	wp_insert_post(
		[
			'post_type'   => 'kc_subscriber',
			'post_title'  => $email,
			'post_status' => 'publish',
		]
	);

	wp_send_json_success( [ 'message' => __( 'Thank you for subscribing!', 'kuchcreation' ) ] );
}
add_action( 'wp_ajax_kc_newsletter_signup', 'kc_ajax_newsletter_signup' );
add_action( 'wp_ajax_nopriv_kc_newsletter_signup', 'kc_ajax_newsletter_signup' );
