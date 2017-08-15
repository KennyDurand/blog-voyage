<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Blog Expert
 */

?>
	<div class="entry-content">
		<div class="pb-30 mb-60">
	    <header class="entry-header">
	        <div class="entry-meta entry-inner">
	            <?php
	            blog_expert_posted_details(); ?>
	        </div><!-- .entry-meta -->
	    </header><!-- .entry-header -->
			<?php
			$image_values = get_post_meta( $post->ID, 'blog-expert-meta-image-layout', true );
			if ( empty( $image_values ) ) {
				$values = esc_attr( blog_expert_get_option('single_post_image_layout') );
			} else{
				$values = esc_attr($image_values);
			}
			if( 'no-image' != $values ){
				if( 'left' == $values ){
					echo "<div class='image-left'>";
					the_post_thumbnail('medium');
				}
				elseif( 'right' == $values ){
					echo "<div class='image-right'>";
					the_post_thumbnail('medium');
				}
				else{
					echo "<div class='image-full'>";
					the_post_thumbnail('full');
				}
				echo "</div>";/*div end */
			}
		?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blog-expert' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	</div><!-- .entry-content -->

	<footer class="entry-footer secondary-bgcolor primary-font">
		<?php blog_expert_entry_category(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

