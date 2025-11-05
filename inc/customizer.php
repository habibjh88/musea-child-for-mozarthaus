<?php

function mozarat_customize_register( $wp_customize ) {

	// Add a section for Mozarat Options
	$wp_customize->add_section( 'mozarat_options_section', array(
		'title'       => __( 'Mozarat Options', 'mozarat' ),
		'priority'    => 160,
		'description' => __( 'Global settings for the Mozarat theme.', 'mozarat' ),
	) );

	// Add setting for Footer Image
	$wp_customize->add_setting( 'mozarat_footer_image', array(
		'default'           => '',
		'type'              => 'theme_mod', // ensures value is saved as a theme mod
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_url_raw',
	) );

	// Add control (media uploader)
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'mozarat_footer_image_control',
			array(
				'label'       => __( 'Footer Background Image', 'mozarat' ),
				'section'     => 'mozarat_options_section',
				'settings'    => 'mozarat_footer_image',
				'description' => __( 'Upload an image for the footer background.', 'mozarat' ),
			)
		)
	);
}
add_action( 'customize_register', 'mozarat_customize_register' );