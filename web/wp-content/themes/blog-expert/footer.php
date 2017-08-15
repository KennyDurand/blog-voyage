<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blog Expert
 */

?>

<?php if (is_active_sidebar('slide-menu')) : ?>
    <div id="sidr-nav">
        <a class="sidr-class-sidr-button-close secondary-bgcolor" href="#sidr-nav"><?php echo esc_html__('Close','blog-expert'); ?> <i class="ion-ios-close"></i></a>
        <!-- slider menu sidebar content -->
        <?php dynamic_sidebar('slide-menu'); ?>
    </div>
<?php endif; ?>
</div><!-- #content -->
    <footer id="colophon" class="site-footer" role="contentinfo">
    <?php $blog_expert_footer_widgets_number = blog_expert_get_option('number_of_footer_widget');
    if ($blog_expert_footer_widgets_number != 0) {?>
        <div class="footer-widget pt-60 pb-50">
            <div class="container">
                <?php
                if (1 == $blog_expert_footer_widgets_number) {
                    $col = 'col-md-12';
                } elseif (2 == $blog_expert_footer_widgets_number) {
                    $col = 'col-md-6';
                } elseif (3 == $blog_expert_footer_widgets_number) {
                    $col = 'col-md-4';
                } elseif (4 == $blog_expert_footer_widgets_number) {
                    $col = 'col-md-3';
                } else {
                    $col = 'col-md-3';
                }
                if (is_active_sidebar('footer-col-one') || is_active_sidebar('footer-col-two') || is_active_sidebar('footer-col-three') || is_active_sidebar('footer-col-four')) { ?>

                        <div class="row">
                            <?php if (is_active_sidebar('footer-col-one') && $blog_expert_footer_widgets_number > 0) : ?>
                                <div class="contact-list <?php echo esc_attr($col); ?>">
                                    <?php dynamic_sidebar('footer-col-one'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (is_active_sidebar('footer-col-two') && $blog_expert_footer_widgets_number > 1) : ?>
                                <div class="contact-list <?php echo esc_attr($col); ?>">
                                    <?php dynamic_sidebar('footer-col-two'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (is_active_sidebar('footer-col-three') && $blog_expert_footer_widgets_number > 2) : ?>
                                <div class="contact-list <?php echo esc_attr($col); ?>">
                                    <?php dynamic_sidebar('footer-col-three'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (is_active_sidebar('footer-col-four') && $blog_expert_footer_widgets_number > 3) : ?>
                                <div class="contact-list <?php echo esc_attr($col); ?>">
                                    <?php dynamic_sidebar('footer-col-four'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                <?php } ?>
            </div>
        </div>
    <?php } ?>
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="site-info text-center">
                            <h5 class="site-copyright alt-font">
                                <?php
                                $blog_expert_copyright_text = wp_kses_post(blog_expert_get_option('copyright_text'));
                                if (!empty ($blog_expert_copyright_text)) {
                                    echo wp_kses_post(blog_expert_get_option('copyright_text'));
                                }
                                ?>
                                <span class="heart"> </span>
                                <?php printf(esc_html__('Theme: %1$s by %2$s', 'blog-expert'), '<strong>Blog Expert</strong>', '<a href="http://themeinwp.com/" target = "_blank" rel="designer"><strong>Themeinwp</strong></a>'); ?>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<div class="scroll-up alt-bgcolor">
    <i class="ion-ios-arrow-up text-light"></i>
</div>


<?php wp_footer(); ?>

</body>
</html>
