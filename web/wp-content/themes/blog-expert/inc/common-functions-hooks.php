<?php
if ( ! function_exists( 'blog_expert_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since Blog Expert 1.0.0
 */
function blog_expert_the_custom_logo() {
    if ( function_exists( 'the_custom_logo' ) ) {
        the_custom_logo();
    }
}
endif;


if ( ! function_exists( 'blog_expert_body_class' ) ) :

	/**
	 * body class.
	 *
	 * @since 1.0.0
	 */
	function blog_expert_body_class($blog_expert_body_class) {
		global $post;
		$global_layout = blog_expert_get_option( 'global_layout' );
		$input = '';
		$home_content_status =	blog_expert_get_option( 'home_page_content_status' );
		if( 1 != $home_content_status ){
			$input = 'home-content-not-enabled';
		}
		// Check if single.
		if ( $post && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'blog-expert-meta-select-layout', true );
			if ( empty( $post_options ) ) {
				$global_layout = esc_attr( blog_expert_get_option('global_layout') );
			} else{
				$global_layout = esc_attr($post_options);
			}
		}
		if ($global_layout == 'left-sidebar') {
			$blog_expert_body_class[]= 'left-sidebar ' . esc_attr( $input );
		}
		elseif ($global_layout == 'no-sidebar') {
			$blog_expert_body_class[]= 'no-sidebar ' . esc_attr( $input );
		}
		else{
			$blog_expert_body_class[]= 'right-sidebar ' . esc_attr( $input );

		}
		return $blog_expert_body_class;
	}
endif;

add_action( 'body_class', 'blog_expert_body_class' );

add_action( 'blog_expert_action_sidebar', 'blog_expert_add_sidebar' );


/**
* Returns word count of the sentences.
*
* @since Blog Expert 1.0.0
*/
if ( ! function_exists( 'blog_expert_words_count' ) ) :
	function blog_expert_words_count( $length = 25, $blog_expert_content = null ) {
		$length = absint( $length );
		$source_content = preg_replace( '`\[[^\]]*\]`', '', $blog_expert_content );
		$trimmed_content = wp_trim_words( $source_content, $length, '' );
		return $trimmed_content;
	}
endif;


if ( ! function_exists( 'blog_expert_simple_breadcrumb' ) ) :

	/**
	 * Simple breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function blog_expert_simple_breadcrumb() {

		if ( ! function_exists( 'breadcrumb_trail' ) ) {

			require_once get_template_directory() . '/assets/libraries/breadcrumbs/breadcrumbs.php';
		}

		$breadcrumb_args = array(
			'container'   => 'div',
			'show_browse' => false,
		);
		breadcrumb_trail( $breadcrumb_args );

	}

endif;


if ( ! function_exists( 'blog_expert_custom_posts_navigation' ) ) :
	/**
	 * Posts navigation.
	 *
	 * @since 1.0.0
	 */
	function blog_expert_custom_posts_navigation() {

		$pagination_type = blog_expert_get_option( 'pagination_type' );

		switch ( $pagination_type ) {

			case 'default':
				the_posts_navigation();
			break;

			case 'numeric':
				the_posts_pagination();
			break;

			default:
			break;
		}

	}
endif;

add_action( 'blog_expert_action_posts_navigation', 'blog_expert_custom_posts_navigation' );


if( ! function_exists( 'blog_expert_excerpt_length' ) && ! is_admin() ) :

    /**
     * Excerpt length
     *
     * @since  Blog Expert 1.0.0
     *
     * @param null
     * @return int
     */
    function blog_expert_excerpt_length( $length ){
        $excerpt_length = blog_expert_get_option( 'excerpt_length_global' );

        if ( absint( $excerpt_length ) > 0 ) {
        	$length = absint( $excerpt_length );
        }

        return $length;

    }

add_filter( 'excerpt_length', 'blog_expert_excerpt_length', 999 );
endif;


if ( ! function_exists( 'blog_expert_excerpt_more' ) && ! is_admin() )  :

	/**
	 * Implement read more in excerpt.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The excerpt.
	 */
	function blog_expert_excerpt_more( $more ) {

		$flag_apply_excerpt_read_more = apply_filters( 'blog_expert_filter_excerpt_read_more', true );
		if ( true !== $flag_apply_excerpt_read_more ) {
			return $more;
		}

		$output = $more;
		$read_more_text = esc_html__('Continue Reading','blog-expert');
		if ( ! empty( $read_more_text ) ) {
			$output = ' <a href="'. esc_url( get_permalink() ) . '" class="read-more">' . esc_html( $read_more_text ) . '<i class="ion-ios-arrow-right read-more-right"></i>' . '</a>';
			$output = apply_filters( 'blog_expert_filter_read_more_link' , $output );
		}
		return $output;

	}

add_filter('excerpt_more', 'blog_expert_excerpt_more');
endif;

if ( ! function_exists( 'blog_expert_get_link_url' ) ) :

	/**
	 * Return the post URL.
	 *
	 * Falls back to the post permalink if no URL is found in the post.
	 *
	 * @since 1.0.0
	 *
	 * @return string The Link format URL.
	 */
	function blog_expert_get_link_url() {
		$content = get_the_content();
		$has_url = get_url_in_content( $content );

		return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}

endif;