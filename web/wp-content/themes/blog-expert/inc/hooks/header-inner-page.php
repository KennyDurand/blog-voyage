<?php
global $post;
if (!function_exists('blog_expert_single_page_title')) :
    function blog_expert_single_page_title()
    { 
        global $post;
        $global_banner_image = get_header_image();
        // Check if single.
            if (is_singular()) {
                if ( has_post_thumbnail( $post->ID ) ) {
                    $banner_image_single_post = get_post_meta( $post->ID, 'blog-expert-meta-checkbox', true );
                    if ( 'yes' == $banner_image_single_post ) {
                        $banner_image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'blog-expert-header-image' );
                        $global_banner_image = $banner_image_array[0];
                    }
                }
            }
            ?>
        <div class="wrapper page-inner-title inner-banner primary-bgcolor data-bg " data-background="<?php echo esc_url($global_banner_image); ?>">
            <header class="entry-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <?php if (is_singular()) { ?>
                                <?php the_title('<h1 class="entry-title alt-font">', '</h1>');
                            } elseif (is_404()) { ?>
                                <h1 class="entry-title alt-font"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'blog-expert'); ?></h1>
                            <?php } elseif (is_archive()) {
                                the_archive_title('<h1 class="entry-title alt-font">', '</h1>');
                                the_archive_description('<div class="taxonomy-description">', '</div>');
                            } elseif (is_search()) { ?>
                                <h1 class="entry-title alt-font"><?php printf(esc_html__('Search Results for: %s', 'blog-expert'), '<span>' . get_search_query() . '</span>'); ?></h1>
                            <?php } else { ?>
                                <h1 class="entry-title alt-font"><?php esc_html_e('Latest Blog', 'blog-expert'); ?></h1>
                            <?php }
                            ?>
                        </div>
                        <?php
                            /**
                            * Hook - blog_expert_add_breadcrumb.
                            */
                            do_action( 'blog_expert_action_breadcrumb' );
                        ?>
                    </div>
                </div>
            </header><!-- .entry-header -->
            <div class="inner-header-overlay blend-color">

            </div>
        </div>

        <?php
    }
endif;
add_action('blog-expert-page-inner-title', 'blog_expert_single_page_title', 15);
