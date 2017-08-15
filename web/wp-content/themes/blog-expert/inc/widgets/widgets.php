<?php
/**
 * Theme widgets.
 *
 * @package Blog Expert
 */

// Load widget base.
require_once get_template_directory() . '/inc/widgets/widget-base-class.php';

if (!function_exists('blog_expert_load_widgets')) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function blog_expert_load_widgets()
    {
        // Recent Post widget.
        register_widget('Blog_Expert_sidebar_widget');

        // Auther widget.
        register_widget('Blog_Expert_Author_Post_widget');

    }
endif;
add_action('widgets_init', 'blog_expert_load_widgets');

/*Grid Panel widget*/
if (!class_exists('Blog_Expert_sidebar_widget')) :

    /**
     * Popular widget Class.
     *
     * @since 1.0.0
     */
    class Blog_Expert_sidebar_widget extends Blog_Expert_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'blog_expert_popular_post_widget',
                'description' => __('Displays post form selected category specific for popular post in sidebars.', 'blog-expert'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'blog-expert'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'post_category' => array(
                    'label' => __('Select Category:', 'blog-expert'),
                    'type' => 'dropdown-taxonomies',
                    'show_option_all' => __('All Categories', 'blog-expert'),
                ),
                'post_number' => array(
                    'label' => __('Number of Posts:', 'blog-expert'),
                    'type' => 'number',
                    'default' => 4,
                    'css' => 'max-width:60px;',
                    'min' => 1,
                    'max' => 6,
                ),
            );

            parent::__construct('blog-expert-popular-sidebar-layout', __('BB: Recent Post', 'blog-expert'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if (!empty($params['title'])) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            }

            $qargs = array(
                'posts_per_page' => esc_attr($params['post_number']),
                'no_found_rows' => true,
            );
            if (absint($params['post_category']) > 0) {
                $qargs['category'] = absint($params['post_category']);
            }
            $all_posts = get_posts($qargs);
            ?>
            <?php global $post; 
            $count = 1;
            ?>
            <?php if (!empty($all_posts)) : ?>
            <div class="twp-recent-widget">                
                <ul class="recent-widget-list">
                <?php foreach ($all_posts as $key => $post) : ?>
                    <?php setup_postdata($post); ?>
                    <li>
                        <article class="article-list">
                            <div class="article-image">
                            <?php if (has_post_thumbnail()) {
                                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'blog-expert-900-600' );
                                $url = $thumb['0'];
                                } else {
                                    $url = get_template_directory_uri() . '/images/no-image.jpg';
                            }
                            ?>
                            <a href="<?php the_permalink(); ?>" class="bg-image bg-image-1">
                                <img src="<?php echo esc_url($url); ?>" alt="<?php the_title_attribute(); ?>">
                            </a>
                                <div class="trend-item">
                                    <span class="number"> <?php echo $count; ?></span>
                                </div>
                            </div>
                            <div class="article-body">
                                <div class="post-meta">
                                    <span class="posts-date alt-bgcolor">
                                    <i class="icon ion-ios-calendar meta-icon alt-color"></i>
                                        <?php the_time('j M Y'); ?></span>
                                </div>
                                <h5>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h5>
                            </div>
                        </article>
                    </li>
                <?php 
                $count++;
                endforeach; ?>
                </ul>
            </div>

            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
            <?php echo $args['after_widget'];
        }
    }
endif;

/*Video widget*/
if (!class_exists('Blog_Expert_Author_Post_widget')) :

    /**
     * Author widget Class.
     *
     * @since 1.0.0
     */
    class Blog_Expert_Author_Post_widget extends Blog_Expert_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'blog_expert_author_widget',
                'description' => __('Displays authors details in post.', 'blog-expert'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'blog-expert'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'author-name' => array(
                    'label' => __('Name:', 'blog-expert'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'discription' => array(
                    'label' => __('Discription:', 'blog-expert'),
                    'type'  => 'textarea',
                    'class' => 'widget-content widefat'
                ),
                'image_url' => array(
                    'label' => __('Author Image:', 'blog-expert'),
                    'type'  => 'image',
                ),
                'url-fb' => array(
                   'label' => __('Facebook URL:', 'blog-expert'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
                'url-tw' => array(
                   'label' => __('Twitter URL:', 'blog-expert'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
                'url-gp' => array(
                   'label' => __('Googleplus URL:', 'blog-expert'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
                'url-lt' => array(
                   'label' => __('Linkedin URL:', 'blog-expert'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
                'url-ig' => array(
                   'label' => __('Instagram URL:', 'blog-expert'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
            );

            parent::__construct('blog-expert-author-layout', __('BB: Author Widget', 'blog-expert'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if ( ! empty( $params['title'] ) ) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            } ?>

            <!--cut from here-->
            <div class="author-info">
                <div class="author-image">
                    <?php if ( ! empty( $params['image_url'] ) ) { ?>
                        <div class="profile-image bg-image">
                            <img src="<?php echo esc_url( $params['image_url'] ); ?>">
                        </div>
                    <?php } ?>
                </div> <!-- /#author-image -->
                <div class="author-details">
                    <?php if ( ! empty( $params['author-name'] ) ) { ?>
                        <h3 class="author-name"><?php echo esc_html($params['author-name'] );?></h3>
                    <?php } ?>
                    <?php if ( ! empty( $params['discription'] ) ) { ?>
                        <p><?php echo wp_kses_post( $params['discription']); ?></p>
                    <?php } ?>
                </div> <!-- /#author-details -->
                <div class="author-social">
                    <?php if ( ! empty( $params['url-fb'] ) ) { ?>
                        <a href="<?php echo esc_url($params['url-fb']); ?>"><i class="meta-icon ion-social-facebook"></i></a>
                    <?php } ?>
                    <?php if ( ! empty( $params['url-tw'] ) ) { ?>
                        <a href="<?php echo esc_url($params['url-tw']); ?>"><i class="meta-icon ion-social-twitter"></i></a>
                    <?php } ?>
                    <?php if ( ! empty( $params['url-gp'] ) ) { ?>
                        <a href="<?php echo esc_url($params['url-gp']); ?>"><i class="meta-icon ion-social-googleplus"></i></a>
                    <?php } ?>
                    <?php if ( ! empty( $params['url-lt'] ) ) { ?>
                        <a href="<?php echo esc_url($params['url-lt']); ?>"><i class="meta-icon ion-social-linkedin"></i></a>
                    <?php } ?>
                    <?php if ( ! empty( $params['url-ig'] ) ) { ?>
                        <a href="<?php echo esc_url($params['url-ig']); ?>"><i class="meta-icon ion-social-instagram"></i></a>
                    <?php } ?>
                </div>
            </div>
            <?php echo $args['after_widget'];
        }
    }
endif;


