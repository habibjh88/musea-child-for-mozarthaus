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

	wp_enqueue_script( 'neuzin-appear', get_stylesheet_directory_uri() . '/assets/js/scripts.js', [ 'jquery' ], 1.1, true );

}

/*add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'musea-parent-style', get_template_directory_uri() . '/style.css' );
} );*/
