<?php
$eltdf_blog_type = musea_elated_get_archive_blog_list_layout();
musea_elated_include_blog_helper_functions( 'lists', $eltdf_blog_type );
$eltdf_holder_params = musea_elated_get_holder_params_blog();
global $musea_exclude_post;
get_header();
musea_elated_get_title();
//musea_elated_get_blog( $eltdf_blog_type );
$sidebar_layout   = musea_elated_sidebar_layout();
$grid_space_meta  = musea_elated_get_meta_field_intersect( 'blog_list_grid_space', musea_elated_get_page_id() );
$holder_classes   = array();
$holder_classes[] = ! empty( $grid_space_meta ) ? 'eltdf-grid-' . $grid_space_meta . '-gutter' : 'eltdf-grid-large-gutter';
$holder_classes   = apply_filters( 'musea_elated_filter_blog_holder_classes', $holder_classes );
$holder_classes   = implode( ' ', $holder_classes );
$blog_type        = $eltdf_blog_type;
do_action( 'musea_elated_action_before_main_content' );
$has_sidebar = is_active_sidebar( 'sidebar' );

$sticky = get_option( 'sticky_posts' );

$sticky_post_id = ! empty( $sticky[0] ) ? $sticky[0] : '';
?>

    <div class="<?php echo esc_attr( $eltdf_holder_params['holder'] ); ?> <?php echo $has_sidebar ? esc_attr( 'has-sidebar' ) : ''; ?>">
		<?php do_action( 'musea_elated_action_after_container_open' ); ?>


        <div class="<?php echo esc_attr( $eltdf_holder_params['inner'] ); ?>">
            <div class="upseo-row">
                <div class="eltdf-blog-archive">
                    <!-- Sticky Post -->
                    <div class="upseo-sticky-post eltdf-grid-row <?php echo esc_attr( $holder_classes ); ?>">
						<?php musea_elated_get_sticky_post( $blog_type, $sticky_post_id ) ?>
                    </div>
                    <!-- Blog Post List -->
                    <div class="eltdf-grid-row <?php echo esc_attr( $holder_classes ); ?>">
						<?php
						$blog_query    = musea_elated_get_blog_query_child($sticky_post_id);
						$paged         = isset( $blog_query->query['paged'] ) ? $blog_query->query['paged'] : 1;
						$max_num_pages = $blog_query->max_num_pages;

						$blog_classes     = musea_elated_get_blog_list_holder_classes( $blog_type );
						$blog_data_params = musea_elated_get_blog_holder_data_params( $blog_type );

						$params = array(
							'blog_query'       => $blog_query,
							'paged'            => $paged,
							'max_num_pages'    => $max_num_pages,
							'blog_type'        => $blog_type,
							'blog_classes'     => $blog_classes,
							'blog_data_params' => $blog_data_params,
						);


						musea_elated_get_module_template_part( 'templates/lists/' . $blog_type . '/list', 'blog', '', $params ); ?>
                    </div>
                </div>

				<?php if ( $has_sidebar ) { ?>
                    <div class="eltdf-sidebar-holder">
						<?php get_sidebar(); ?>
                    </div>
				<?php } ?>
            </div>

        </div>


    </div>


<?php do_action( 'musea_elated_action_before_container_close' ); ?>
    </div>

<?php do_action( 'musea_elated_action_blog_list_additional_tags' ); ?>
<?php get_footer(); ?>