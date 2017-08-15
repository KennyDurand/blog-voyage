<?php
/**
 * CSS related hooks.
 *
 * This file contains hook functions which are related to CSS.
 *
 * @package Blog Expert
 */

if (!function_exists('blog_expert_trigger_custom_css_action')) :

    /**
     * Do action theme custom CSS.
     *
     * @since 1.0.0
     */
    function blog_expert_trigger_custom_css_action()
    {
        $blog_expert_enable_banner_overlay = blog_expert_get_option('enable_overlay_option');
        ?>
        <style type="text/css">
            <?php
            /* Banner Image */
            if ( $blog_expert_enable_banner_overlay == 1 ){
                ?>
                body .hero-slider.overlay .slide-item .bg-image:before,
                body .inner-header-overlay{
                    filter: alpha(opacity=85);
                    opacity: .85;
                }
            <?php
        } ?>
        </style>

    <?php }

endif;