<?php
/**
 * Title + Text + Two Buttons Block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'vc_before_init', 'mozart_register_title_buttons_block' );
function mozart_register_title_buttons_block() {

	vc_map( array(
		'name'        => __( 'Title, Buttons & Slider Block', 'mozart-child' ),
		'base'        => 'mozart_title_buttons_block',
		'description' => __( 'A block with title, text, and two buttons', 'mozart-child' ),
		'category'    => __( 'Mozart Elements', 'mozart-child' ),
		'icon'        => 'dashicons-editor-bold',
		'params'      => array(
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Title', 'mozart-child' ),
				'param_name'  => 'title',
				'admin_label' => true,
			),
			array(
				'type'       => 'textarea_html',
				'heading'    => __( 'Content', 'mozart-child' ),
				'param_name' => 'content',
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Button 1 Text', 'mozart-child' ),
				'param_name' => 'btn1_text',
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Button 2 Text', 'mozart-child' ),
				'param_name' => 'btn2_text',
			),
			array(
				'type'        => 'attach_images',
				'heading'     => __( 'Slider Images', 'mozart-child' ),
				'param_name'  => 'slider_images',
				'description' => __( 'Upload or select multiple images for the slider.', 'mozart-child' ),
			),
		),
	) );
}

add_shortcode( 'mozart_title_buttons_block', 'mozart_render_title_buttons_block' );
function mozart_render_title_buttons_block( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title'         => '',
		'btn1_text'     => '',
		'btn2_text'     => '',
		'slider_images' => '',
	), $atts ) );


	ob_start(); ?>

    <div class="mozart-title-buttons-block">
        <div class="title-block-header">
			<?php if ( $title ) : ?>
                <h2 class="mozart-block-title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( $btn1_text ) : ?>
                <span class="btn btn-1">
				<?php echo esc_html( $btn1_text ); ?>
				</span>
			<?php endif; ?>

			<?php if ( $btn2_text ) : ?>
                <span class="btn btn-2">
                <svg focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="QueryBuilderRoundedIcon"
                     class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium MuiChip-icon MuiChip-iconMedium MuiChip-iconColorDefault re-c-1dzmpkw">
                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm-.22-13h-.06c-.4 0-.72.32-.72.72v4.72c0 .35.18.68.49.86l4.15 2.49c.34.2.78.1.98-.24.21-.34.1-.79-.25-.99l-3.87-2.3V7.72c0-.4-.32-.72-.72-.72z"></path>
                </svg>
				<?php echo esc_html( $btn2_text ); ?>
            </span>
			<?php endif; ?>
        </div>

		<?php if ( $slider_images ) :
			$image_ids = explode( ',', $slider_images );
			$slider_height = 500;
            $total_images = count( $image_ids );
			$thumb_height = $slider_height / $total_images;
			?>

            <div class="mozart-swiper-wrapper" style="--slider-height:<?php echo esc_attr( $slider_height ) ?>px"
                 data-gallery-perview="<?php echo esc_attr( $total_images ) ?>">
                <div class="swiper-container mozart-swiper-thumbs">
                    <div class="swiper-wrapper">
						<?php foreach ( $image_ids as $img_id ) :
							$thumb_url = wp_get_attachment_image_url( $img_id, 'thumbnail' ); ?>
                            <div class="swiper-slide" style="height: <?php echo esc_attr( $thumb_height ); ?>">
                                <img src="<?php echo esc_url( $thumb_url ); ?>" alt="">
                            </div>
						<?php endforeach; ?>
                    </div>
                </div>

                <div class="swiper-container mozart-swiper-main">
                    <div class="swiper-wrapper">
						<?php foreach ( $image_ids as $img_id ) :
							$img_url = wp_get_attachment_image_url( $img_id, 'large' ); ?>
                            <div class="swiper-slide">
                                <img src="<?php echo esc_url( $img_url ); ?>" alt="">
                            </div>
						<?php endforeach; ?>
                    </div>

                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
		<?php endif; ?>

        <div class="mozart-block-text">
			<?php echo wpb_js_remove_wpautop( $content, true ); ?>
        </div>

    </div>

	<?php
	return ob_get_clean();
}