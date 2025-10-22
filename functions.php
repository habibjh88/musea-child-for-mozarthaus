<?php

add_action( 'wp_enqueue_scripts', 'musea_child_styles' );
function musea_child_styles() {
	// Parent style
	wp_enqueue_style(
		'musea-parent-style',
		get_template_directory_uri() . '/style.css',
		[],
		wp_get_theme( 'Musea' )->get( 'Version' )
	);

	// Child style
	wp_enqueue_style(
		'musea-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'musea-parent-style' ], // ensure child loads after parent
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11.0.0' );
	wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11.0.0', true );


	wp_enqueue_script( 'neuzin-appear', get_stylesheet_directory_uri() . '/assets/js/scripts.js', [ 'jquery' ], 1.1, true );

}

add_filter( 'body_class', function( $classes ) {
    $meta_content = get_post_meta( get_the_ID(), '_musea_layout_option', true );
    if( 'content-layout' === $meta_content ) {
	    $classes[] = 'musea-layout-content';
    }
	if( 'content-layout-narrow' === $meta_content ) {
	    $classes[] = 'musea-layout-content narrow';
    }

	return $classes;
} );

// Include WPBakery custom elements
require_once get_stylesheet_directory() . '/wpbakery/init.php';
require_once get_stylesheet_directory() . '/inc/meta.php';