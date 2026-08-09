<?php
/**
 * Exposes the brand accent color in the Customizer so it can be changed
 * without touching code. Every other token stays in tokens.css — this is
 * the one color a non-developer is likely to want to tweak.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KC_DEFAULT_ACCENT', '#b5654a' );

function kc_customize_register( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section(
		'kc_brand',
		[
			'title'    => __( 'Kuch Creation Brand', 'kuchcreation' ),
			'priority' => 30,
		]
	);

	$wp_customize->add_setting(
		'kc_accent_color',
		[
			'default'           => KC_DEFAULT_ACCENT,
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		]
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'kc_accent_color',
			[
				'label'   => __( 'Accent Color', 'kuchcreation' ),
				'section' => 'kc_brand',
			]
		)
	);

	$wp_customize->add_setting(
		'kc_announcement_text',
		[
			'default'           => __( 'Free Shipping on Orders Above ₹999', 'kuchcreation' ),
			'sanitize_callback' => 'sanitize_text_field',
		]
	);
	$wp_customize->add_control(
		'kc_announcement_text',
		[
			'label'   => __( 'Announcement Bar Text', 'kuchcreation' ),
			'section' => 'kc_brand',
			'type'    => 'text',
		]
	);
}
add_action( 'customize_register', 'kc_customize_register' );

function kc_accent_color_inline_style() {
	$accent = get_theme_mod( 'kc_accent_color', KC_DEFAULT_ACCENT );

	if ( strtolower( $accent ) === strtolower( KC_DEFAULT_ACCENT ) ) {
		return;
	}

	wp_add_inline_style( 'kc-tokens', ":root{--color-accent:{$accent};}" );
}
add_action( 'wp_enqueue_scripts', 'kc_accent_color_inline_style', 21 );
