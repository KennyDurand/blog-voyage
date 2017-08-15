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
        <header class="article-header text-center">
		<?php if ( is_single() ) : ?>
			<div class="post-category ribbon alt-bgcolor primary-font mb-20">
				<span class="ribbon-span">
			    	<?php blog_expert_entry_category(); ?>
				</span>
			</div>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php else : ?>
			<div class="post-category ribbon alt-bgcolor primary-font mb-20">
				<span class="ribbon-span">
			    	<?php blog_expert_entry_category(); ?>
				</span>
			</div>
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php endif; ?>
		</header>
	    <div class="entry-meta primary-font">
	        <?php blog_expert_posted_details(); ?>
	    </div><!-- .entry-meta -->
	   
	    <div class="entry-content twp-entry-content">
	        
	            <?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <i class="ion-ios-arrow-right read-more-right"></i>', 'blog-expert' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
				?>
	    </div><!-- .entry-content -->
		<div class="post-tags primary-font text-center text-uppercase">
			<?php blog_expert_entry_tags(); ?>
	    </div>
	</div>
</article><!-- #post-## -->
