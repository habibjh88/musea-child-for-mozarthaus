

<?php
add_action( 'wp_enqueue_scripts', 'musea_child_styles', 90 );
function musea_child_styles() {
	wp_enqueue_style(
		'musea-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		null,
		filemtime(get_stylesheet_directory() . '/style.css')
	);
}
