<?php
/**
 * Mozart Image Slider (Swiper version)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// === Register WPBakery Element ===
add_action( 'vc_before_init', 'mozart_register_image_slider_block' );
function mozart_register_image_slider_block() {

	vc_map( array(
		'name'        => __( 'Mozart Image Slider', 'mozart-child' ),
		'base'        => 'mozart_image_slider',
		'description' => __( 'Responsive Image Slider using Swiper.js', 'mozart-child' ),
		'category'    => __( 'Mozart Elements', 'mozart-child' ),
		'icon'        => 'dashicons-images-alt2',
		'params'      => array(

			// Image Gallery
			array(
				'type'        => 'attach_images',
				'heading'     => __( 'Slider Images', 'mozart-child' ),
				'param_name'  => 'images',
				'description' => __( 'Upload or select multiple images for the slider.', 'mozart-child' ),
				'group'       => __( 'Content', 'mozart-child' ),
			),

			// Slider Height
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Slider Height (px)', 'mozart-child' ),
				'param_name'  => 'slider_height',
				'value'       => '500',
				'description' => __( 'Enter the height of the slider in pixels (e.g. 500)', 'mozart-child' ),
				'group'       => __( 'Style', 'mozart-child' ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Slider Gap (px)', 'mozart-child' ),
				'param_name'  => 'slider_gap',
				'value'       => '15',
				'description' => __( 'Enter slider gap.', 'mozart-child' ),
				'group'       => __( 'Style', 'mozart-child' ),
			),

			// Responsive Columns
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Desktop Columns', 'mozart-child' ),
				'param_name' => 'columns_desktop',
				'value'      => array( 1, 2, 3, 4, 5, 6 ),
				'std'        => '3',
				'group'      => __( 'Responsive', 'mozart-child' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Tablet Columns', 'mozart-child' ),
				'param_name' => 'columns_tablet',
				'value'      => array( 1, 2, 3, 4 ),
				'std'        => '2',
				'group'      => __( 'Responsive', 'mozart-child' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Mobile Columns', 'mozart-child' ),
				'param_name' => 'columns_mobile',
				'value'      => array( 1, 2 ),
				'std'        => '1',
				'group'      => __( 'Responsive', 'mozart-child' ),
			),
		),
	) );
}

// === Shortcode Render ===
add_shortcode( 'mozart_image_slider', 'mozart_render_image_slider_block' );
function mozart_render_image_slider_block( $atts ) {
	extract( shortcode_atts( array(
		'images'          => '',
		'slider_height'   => '500',
		'columns_desktop' => 3,
		'columns_tablet'  => 2,
		'columns_mobile'  => 1,
		'slider_gap'      => '15',
	), $atts ) );

	if ( empty( $images ) ) {
		return '';
	}

	$uid       = 'mozart-slider-' . wp_rand( 1000, 9999 );
	$image_ids = explode( ',', $images );

	wp_enqueue_script( 'lightbox2' );
	wp_enqueue_style( 'lightbox2' );

	ob_start(); ?>

    <div id="<?php echo esc_attr( $uid ); ?>"
         data-gap="<?php echo esc_attr( $slider_gap ); ?>"
         data-desktop="<?php echo esc_attr( $columns_desktop ); ?>"
         data-tablet="<?php echo esc_attr( $columns_tablet ); ?>"
         data-mobile="<?php echo esc_attr( $columns_mobile ); ?>"
         class="mozart-swiper-slider"
         style="--slider-height: <?php echo esc_attr( $slider_height ); ?>px;">
        <div class="swiper">
            <div class="swiper-wrapper">
	            <?php foreach ( $image_ids as $img_id ) :
		            $img_url   = wp_get_attachment_image_url( $img_id, 'large' );
		            $full_url  = wp_get_attachment_image_url( $img_id, 'full' );
		            $img_alt   = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
		            ?>
                    <div class="swiper-slide">
                        <a href="<?php echo esc_url( $full_url ); ?>" data-lightbox="lightbox[rel-<?php echo esc_attr( $uid ); ?>]">
                            <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">
                        </a>
                    </div>
	            <?php endforeach; ?>
            </div>

            <!-- Pagination & Navigation -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>


	<?php
	return ob_get_clean();
}