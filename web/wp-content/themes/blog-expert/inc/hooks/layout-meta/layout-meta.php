<?php
/**
 * Implement theme metabox.
 *
 * @package Blog Expert
 */

if ( ! function_exists( 'blog_expert_add_theme_meta_box' ) ) :

	/**
	 * Add the Meta Box
	 *
	 * @since 1.0.0
	 */
	function blog_expert_add_theme_meta_box() {

		$apply_metabox_post_types = array( 'post', 'page' );

		foreach ( $apply_metabox_post_types as $key => $type ) {
			add_meta_box(
				'blog-expert-theme-settings',
				esc_html__( 'Single Page/Post Settings', 'blog-expert' ),
				'blog_expert_render_theme_settings_metabox',
				$type
			);
		}

	}

endif;

add_action( 'add_meta_boxes', 'blog_expert_add_theme_meta_box' );

if ( ! function_exists( 'blog_expert_render_theme_settings_metabox' ) ) :

	/**
	 * Render theme settings meta box.
	 *
	 * @since 1.0.0
	 */
	function blog_expert_render_theme_settings_metabox( $post, $metabox ) {

		$post_id = $post->ID;
		$blog_expert_post_meta_value = get_post_meta($post_id);

		// Meta box nonce for verification.
		wp_nonce_field( basename( __FILE__ ), 'blog_expert_meta_box_nonce' );
		// Fetch Options list.
		$page_layout = get_post_meta($post_id,'blog-expert-meta-select-layout',true);
		$page_image_layout = get_post_meta($post_id,'blog-expert-meta-image-layout',true);
	?>
	<div id="blog-expert-settings-metabox-container" class="blog-expert-settings-metabox-container">
		<div id="blog-expert-settings-metabox-tab-layout">
			<h4><?php echo __( 'Layout Settings', 'blog-expert' ); ?></h4>
			<div class="blog-expert-row-content">
				 <!-- Checkbox Field-->
				     <p>
				     <div class="blog-expert-row-content">
				         <label for="blog-expert-meta-checkbox">
				             <input type="checkbox" name="blog-expert-meta-checkbox" id="blog-expert-meta-checkbox" value="yes" <?php if ( isset ( $blog_expert_post_meta_value['blog-expert-meta-checkbox'] ) ) checked( $blog_expert_post_meta_value['blog-expert-meta-checkbox'][0], 'yes' ); ?> />
				             <?php _e( 'Check To Use Featured Image As Banner Image', 'blog-expert' )?>
				         </label>
				     </div>
				     </p>
			     <!-- Select Field-->
			        <p>
			            <label for="blog-expert-meta-select-layout" class="blog-expert-row-title">
			                <?php _e( 'Single Page/Post Layout', 'blog-expert' )?>
			            </label>
			            <select name="blog-expert-meta-select-layout" id="blog-expert-meta-select-layout">
				            <option value="left-sidebar" <?php selected('left-sidebar',$page_layout);?>>
				            	<?php _e( 'Primary Sidebar - Content', 'blog-expert' )?>
				            </option>
				            <option value="right-sidebar" <?php selected('right-sidebar',$page_layout);?>>
				            	<?php _e( 'Content - Primary Sidebar', 'blog-expert' )?>
				            </option>
				            <option value="no-sidebar" <?php selected('no-sidebar',$page_layout);?>>
				            	<?php _e( 'No Sidebar', 'blog-expert' )?>
				            </option>
			            </select>
			        </p>

		         <!-- Select Field-->
		            <p>
		                <label for="blog-expert-meta-image-layout" class="blog-expert-row-title">
		                    <?php _e( 'Single Page/Post Image Layout', 'blog-expert' )?>
		                </label>
                        <select name="blog-expert-meta-image-layout" id="blog-expert-meta-image-layout">
            	            <option value="full" <?php selected('full',$page_image_layout);?>>
            	            	<?php _e( 'Full', 'blog-expert' )?>
            	            </option>
            	            <option value="left" <?php selected('left',$page_image_layout);?>>
            	            	<?php _e( 'Left', 'blog-expert' )?>
            	            </option>
            	            <option value="right" <?php selected('right',$page_image_layout);?>>
            	            	<?php _e( 'Right', 'blog-expert' )?>
            	            </option>
            	            <option value="no-image" <?php selected('no-image',$page_image_layout);?>>
            	            	<?php _e( 'No Image', 'blog-expert' )?>
            	            </option>
                        </select>
		            </p>
			</div><!-- .blog-expert-row-content -->
		</div><!-- #blog-expert-settings-metabox-tab-layout -->
	</div><!-- #blog-expert-settings-metabox-container -->

    <?php
	}

endif;



if ( ! function_exists( 'blog_expert_save_theme_settings_meta' ) ) :

	/**
	 * Save theme settings meta box value.
	 *
	 * @since 1.0.0
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post Post object.
	 */
	function blog_expert_save_theme_settings_meta( $post_id, $post ) {

		// Verify nonce.
		if ( ! isset( $_POST['blog_expert_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['blog_expert_meta_box_nonce'], basename( __FILE__ ) ) ) {
			  return; }

		// Bail if auto save or revision.
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}

		// Check permission.
		if ( 'page' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return; }
		} else if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$blog_expert_meta_checkbox =  isset( $_POST[ 'blog-expert-meta-checkbox' ] ) ? esc_attr($_POST[ 'blog-expert-meta-checkbox' ]) : '';
		update_post_meta($post_id, 'blog-expert-meta-checkbox', sanitize_text_field($blog_expert_meta_checkbox));

		$blog_expert_meta_select_layout =  isset( $_POST[ 'blog-expert-meta-select-layout' ] ) ? esc_attr($_POST[ 'blog-expert-meta-select-layout' ]) : '';
		if(!empty($blog_expert_meta_select_layout)){
			update_post_meta($post_id, 'blog-expert-meta-select-layout', sanitize_text_field($blog_expert_meta_select_layout));
		}
		$blog_expert_meta_image_layout =  isset( $_POST[ 'blog-expert-meta-image-layout' ] ) ? esc_attr($_POST[ 'blog-expert-meta-image-layout' ]) : '';
		if(!empty($blog_expert_meta_image_layout)){
			update_post_meta($post_id, 'blog-expert-meta-image-layout', sanitize_text_field($blog_expert_meta_image_layout));
		}
	}

endif;

add_action( 'save_post', 'blog_expert_save_theme_settings_meta', 10, 2 );