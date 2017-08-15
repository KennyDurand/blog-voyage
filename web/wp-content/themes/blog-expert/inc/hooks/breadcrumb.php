<?php 

if ( ! function_exists( 'blog_expert_add_breadcrumb' ) ) :

	/**
	 * Add breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function blog_expert_add_breadcrumb() {

		// Bail if Breadcrumb disabled.
		$breadcrumb_type = blog_expert_get_option( 'breadcrumb_type' );
		if ( 'disabled' === $breadcrumb_type ) {
			return;
		}
		// Bail if Home Page.
		if ( is_front_page() || is_home() ) {
			return;
		}
		// Render breadcrumb.
		echo '<div class="col-md-4 mt-20">';
		switch ( $breadcrumb_type ) {
			case 'simple':
				blog_expert_simple_breadcrumb();
			break;

			case 'advanced':
				if ( function_exists( 'bcn_display' ) ) {
					bcn_display();
				}
			break;

			default:
			break;
		}
		echo '</div><!-- .container -->';
		return;

	}

endif;

add_action( 'blog_expert_action_breadcrumb', 'blog_expert_add_breadcrumb' , 10 );
