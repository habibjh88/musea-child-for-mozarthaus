<?php
/**
 * Add Layout Select Meta Box
 */
function musea_add_layout_meta_box() {
    add_meta_box(
        'musea_layout_meta',              // Meta box ID
        __( 'Page Layout', 'musea-child' ), // Title
        'musea_layout_meta_box_callback', // Callback function
        ['post', 'page'],              // Post types (add more if needed)
        'side',                        // Context (side panel)
        'default'                      // Priority
    );
}
add_action( 'add_meta_boxes', 'musea_add_layout_meta_box' );

/**
 * Meta Box Display Callback
 */
function musea_layout_meta_box_callback( $post ) {
    // Retrieve the current value
    $selected = get_post_meta( $post->ID, '_musea_layout_option', true );
    wp_nonce_field( 'musea_save_layout_meta', 'musea_layout_nonce' );
    ?>
    <p>
        <label for="musea_layout_option"><strong><?php esc_html_e( 'Select Layout:', 'musea-child' ); ?></strong></label>
        <select name="musea_layout_option" id="musea_layout_option">
            <option value="default" <?php selected( $selected, 'default' ); ?>><?php esc_html_e( 'Default', 'musea-child' ); ?></option>
            <option value="content-layout" <?php selected( $selected, 'content-layout' ); ?>><?php esc_html_e( 'Content Layout', 'musea-child' ); ?></option>
            <option value="content-layout-narrow" <?php selected( $selected, 'content-layout-narrow' ); ?>><?php esc_html_e( 'Content Layout Narrow', 'musea-child' ); ?></option>
        </select>
    </p>
    <?php
}

/**
 * Save Layout Meta Box Data
 */
function musea_save_layout_meta_box_data( $post_id ) {
    // Verify nonce
    if ( ! isset( $_POST['musea_layout_nonce'] ) || ! wp_verify_nonce( $_POST['musea_layout_nonce'], 'musea_save_layout_meta' ) ) {
        return;
    }

    // Don't save during autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check permissions
    if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    } elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save value
    if ( isset( $_POST['musea_layout_option'] ) ) {
        update_post_meta( $post_id, '_musea_layout_option', sanitize_text_field( $_POST['musea_layout_option'] ) );
    }
}
add_action( 'save_post', 'musea_save_layout_meta_box_data' );


add_action( 'admin_head-post.php', 'hr_fix_meta_box_margin' );
add_action( 'admin_head-post-new.php', 'hr_fix_meta_box_margin' );

function hr_fix_meta_box_margin() {
	?>
    <style>
        /* Works for meta boxes on Gutenberg pages */
        .block-editor-page .postbox {
            margin: 0 !important;
        }
    </style>
	<?php
}