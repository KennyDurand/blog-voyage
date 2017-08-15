<?php
if (!function_exists('blog_expert_banner_slider_args')) :
    /**
     * Banner Slider Details
     *
     * @since Blog Expert 1.0.0
     *
     * @return array $qargs Slider details.
     */
    function blog_expert_banner_slider_args()
    {
        $blog_expert_banner_slider_number = absint(blog_expert_get_option('number_of_home_slider'));
        $blog_expert_banner_slider_from = esc_attr(blog_expert_get_option('select_slider_from'));
        switch ($blog_expert_banner_slider_from) {
            case 'from-page':
                $blog_expert_banner_slider_page_list_array = array();
                for ($i = 1; $i <= $blog_expert_banner_slider_number; $i++) {
                    $blog_expert_banner_slider_page_list = blog_expert_get_option('select_page_for_slider_' . $i);
                    if (!empty($blog_expert_banner_slider_page_list)) {
                        $blog_expert_banner_slider_page_list_array[] = absint($blog_expert_banner_slider_page_list);
                    }
                }
                // Bail if no valid pages are selected.
                if (empty($blog_expert_banner_slider_page_list_array)) {
                    return;
                }
                /*page query*/
                $qargs = array(
                    'posts_per_page' => esc_attr($blog_expert_banner_slider_number),
                    'orderby' => 'post__in',
                    'post_type' => 'page',
                    'post__in' => $blog_expert_banner_slider_page_list_array,
                );
                return $qargs;
                break;

            case 'from-category':
                $blog_expert_banner_slider_category = absint(blog_expert_get_option('select_category_for_slider'));
                $qargs = array(
                    'posts_per_page' => esc_attr($blog_expert_banner_slider_number),
                    'post_type' => 'post',
                    'cat' => $blog_expert_banner_slider_category,
                );
                return $qargs;
                break;

            default:
                break;
        }
        ?>
        <?php
    }
endif;


if (!function_exists('blog_expert_banner_slider')) :
    /**
     * Banner Slider
     *
     * @since Blog Expert 1.0.0
     *
     */
    function blog_expert_banner_slider()
    {
        $blog_expert_slider_button_text = esc_html(blog_expert_get_option('button_text_on_slider'));
        $blog_expert_slider_excerpt_number = absint(blog_expert_get_option('number_of_content_home_slider'));
        if (1 != blog_expert_get_option('show_slider_section')) {
            return null;
        }
        $blog_expert_banner_slider_args = blog_expert_banner_slider_args();
        $blog_expert_banner_slider_query = new WP_Query($blog_expert_banner_slider_args); ?>
        <section class="twp-slider-wrapper pt-40 pb-20 secondary-bgcolor">
            <div class="twp-slider">
            <?php
            if ($blog_expert_banner_slider_query->have_posts()) :
                while ($blog_expert_banner_slider_query->have_posts()) : $blog_expert_banner_slider_query->the_post();
                    if (has_post_thumbnail()) {
                        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'blog-expert-main-banner');
                        $url = $thumb['0'];
                    } else {
                        $url = get_template_directory_uri().'/images/no-image-ls.jpg';
                    }
                    if (has_excerpt()) {
                        $blog_expert_slider_content = get_the_excerpt();
                    } else {
                        $blog_expert_slider_content = blog_expert_words_count($blog_expert_slider_excerpt_number, get_the_content());
                    }
                    ?>
                    <div class="single-slide">
                        <div class="slide-bg bg-image animated">
                            <img src="<?php echo esc_url($url); ?>">
                        </div>
                        <div class="slide-text animated">
                            <div class="primary-bgcolor bg-overlay"></div>
                            <div class="slide-text-wrapper">
                                <a href="<?php the_permalink(); ?>">
                                    <h2><?php the_title(); ?></h2>
                                </a>
                                <div class="title-seperator secondary-bgcolor"></div>
                                <p class="visible hidden-xs"><?php echo wp_kses_post($blog_expert_slider_content); ?></p>
                                <a href="<?php the_permalink(); ?>" class="twp-btn mb-20">
                                    <?php echo esc_html($blog_expert_slider_button_text); ?> <i class="ion-ios-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif; ?>
            </div>
        </section>
            <!-- end slider-section -->
        <?php
    }
endif;
add_action('blog_expert_action_slider_post', 'blog_expert_banner_slider', 10);