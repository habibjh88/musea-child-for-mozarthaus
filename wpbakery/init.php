<?php
/**
 * Initialize custom WPBakery elements for Mozart Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) exit;



// Auto-load all element files
if ( function_exists( 'vc_map' ) ) {
	$elements_path = get_stylesheet_directory() . '/wpbakery/elements/';
	foreach ( glob( $elements_path . '*.php' ) as $file ) {
		include_once $file;
	}
}