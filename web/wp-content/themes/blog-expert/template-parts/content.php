<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Blog Expert
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="pt-30 pb-30 mb-60 twp-article-wrapper">
        <?php if (!is_single()) { ?>
        <header class="article-header text-center">
            <div class="post-category ribbon alt-bgcolor primary-font mb-20">
                <span class="ribbon-span">
                    <?php blog_expert_entry_category(); ?>
                </span>
            </div>
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
        </header>
        <div class="entry-meta primary-font">
            <?php blog_expert_posted_details(); ?>
        </div><!-- .entry-meta -->
        <?php $archive_layout = blog_expert_get_option('archive_layout'); ?>
        <?php $archive_layout_image = blog_expert_get_option('archive_layout_image'); ?>
        <?php if ('full' == $archive_layout_image) {
            $full_width_content = 'archive-image-full';
        } else {
            $full_width_content = 'twp-archive-lr';
        }
        ?>
        <div class="entry-content twp-entry-content <?php echo esc_attr($full_width_content); ?>">
            <?php $archive_layout = blog_expert_get_option('archive_layout'); ?>
            <?php $archive_layout_image = blog_expert_get_option('archive_layout_image'); ?>

            <?php if (has_post_thumbnail()) :
                if ('left' == $archive_layout_image) {
                    echo "<div class='twp-image-archive image-left'>";
                    the_post_thumbnail('full');
                } elseif ('right' == $archive_layout_image) {
                    echo "<div class='twp-image-archive image-right'>";
                    the_post_thumbnail('full');
                } elseif ('full' == $archive_layout_image) {
                    echo "<div class='twp-image-archive image-full'>";
                    the_post_thumbnail('full');
                } else {
                    echo "<div>";
                }
                echo "</div>";/*div end*/

            endif; ?>
            <div class="twp-archive-content">
                <?php if ('full' == $archive_layout) : ?>

                    <?php
                    the_content(sprintf(
                    /* translators: %s: Name of current post. */
                        wp_kses(__('Continue reading %s <i class="ion-ios-arrow-right read-more-right"></i>', 'blog-expert'), array('span' => array('class' => array()))),
                        the_title('<span class="screen-reader-text">"', '"</span>', false)
                    ));
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'blog-expert'),
                        'after' => '</div>',
                    ));
                    ?>
                <?php else : ?>
                    <?php the_excerpt(); ?>
                <?php endif ?>
            </div>
        </div><!-- .entry-content -->
        <?php } else { ?>
            <div class="entry-content">
                <?php
                $image_values = get_post_meta($post->ID, 'blog-expert-meta-image-layout', true);
                if (empty($image_values)) {
                    $values = esc_attr(blog_expert_get_option('single_post_image_layout'));
                } else {
                    $values = esc_attr($image_values);
                }
                if ('no-image' != $values) {
                    if ('left' == $values) {
                        echo "<div class='image-left'>";
                        the_post_thumbnail('full');
                    } elseif ('right' == $values) {
                        echo "<div class='image-right'>";
                        the_post_thumbnail('full');
                    } else {
                        echo "<div class='image-full'>";
                        the_post_thumbnail('full');
                    }
                    echo "</div>";/*div end */
                }
                ?>
                <?php the_content(); ?>
                <?php
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'blog-expert'),
                    'after' => '</div>',
                ));
                ?>
            </div><!-- .entry-content -->
        <?php } ?>
        <div class="post-tags primary-font text-center text-uppercase">
            <?php blog_expert_entry_tags(); ?>
        </div>
    </div>
</article><!-- #post-## -->
