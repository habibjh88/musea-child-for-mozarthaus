<?php
// Include WPBakery custom elements
require_once get_stylesheet_directory() . '/wpbakery/init.php';
require_once get_stylesheet_directory() . '/inc/meta.php';
require_once get_stylesheet_directory() . '/inc/customizer.php';

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

	// Add inline CSS for footer background
	$footer_image = get_theme_mod( 'mozarat_footer_image' );

	if ( $footer_image ) {
		$custom_css = "
            body .eltdf-page-footer .eltdf-footer-top-holder::before {
                background-image: url('{$footer_image}');
            }
        ";
		wp_add_inline_style( 'musea-child-style', $custom_css );
	}

	wp_enqueue_style( 'swiper-css', get_stylesheet_directory_uri() . '/assets/lib/swiper-bundle.min.css', [], '11.0.0' );
	wp_enqueue_script( 'swiper-js', get_stylesheet_directory_uri() . '/assets/lib/swiper-bundle.min.js', [], '11.0.0', true );
	wp_enqueue_script( 'neuzin-appear', get_stylesheet_directory_uri() . '/assets/js/scripts.js', [ 'jquery' ], 1.4, true );
}


add_filter( 'body_class', function ( $classes ) {
	$meta_content = get_post_meta( get_the_ID(), '_musea_layout_option', true );
	if ( 'content-layout' === $meta_content ) {
		$classes[] = 'musea-layout-content';
	}
	if ( 'content-layout-narrow' === $meta_content ) {
		$classes[] = 'musea-layout-content narrow';
	}

	return $classes;
} );


if ( ! function_exists( 'musea_elated_get_sticky_post' ) ) {
	/**
	 * Function which create query for blog lists
	 *
	 * @param $type string with name of list that is loaded
	 */
	function musea_elated_get_sticky_post( $type ) {
		$sticky = get_option( 'sticky_posts' );

		$sticky_post_id = ! empty( $sticky[0] ) ? $sticky[0] : '';

		if ( ! $sticky_post_id ) {
			return;
		}
		global $musea_exclude_post;
		$musea_exclude_post = $sticky_post_id;

		$args = array(
			'posts_per_page'      => 1,
			'post__in'            => [$sticky_post_id],
			'ignore_sticky_posts' => 1
		);

		$sticky_post = new WP_Query( $args );

		$max_num_pages = $sticky_post->max_num_pages;

		$blog_classes     = musea_elated_get_blog_list_holder_classes( $type );
		$blog_data_params = musea_elated_get_blog_holder_data_params( $type );

		$params = array(
			'blog_query'       => $sticky_post,
			'max_num_pages'    => $max_num_pages,
			'blog_type'        => $type,
			'blog_classes'     => $blog_classes,
			'blog_data_params' => $blog_data_params
		);

		musea_elated_get_module_template_part( 'templates/lists/' . $type . '/list', 'blog', '', $params );
	}
}

if ( ! function_exists( 'musea_elated_get_blog_query_child' ) ) {
	/**
	 * Function which create query for blog lists
	 *
	 * @return wp query object
	 */
	function musea_elated_get_blog_query_child() {
		$id                       = musea_elated_get_page_id();
		$category                 = esc_attr( get_post_meta( $id, 'eltdf_blog_category_meta', true ) );
		$number_of_posts_per_page = get_post_meta( $id, 'eltdf_show_posts_per_page_meta', true );
		$post_number              = ! empty( $number_of_posts_per_page ) ? esc_attr( $number_of_posts_per_page ) : esc_attr( get_option( 'posts_per_page' ) );

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		global $musea_exclude_post;

		$query_array = array(
			'post_status'    => 'publish',
			'post_type'      => 'post',
			'paged'          => $paged,
			'category_name'  => $category,
			'posts_per_page' => $post_number,
		);

		if($musea_exclude_post) {
			$query_array['exclude'] = [$musea_exclude_post];
			$query_array['ignore_sticky_post'] = 1;
		}

		$blog_query = new WP_Query( $query_array );
		if ( is_archive() ) {
			global $wp_query;
			$blog_query = $wp_query;
		}

		return $blog_query;
	}
}