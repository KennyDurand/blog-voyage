<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Blog Expert
 */

if ( ! function_exists( 'blog_expert_posted_details' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function blog_expert_posted_details() {
	global $post;
	$author_id=$post->post_author;
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		'%s',
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		'%s',
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $author_id ) ) . '">' . esc_html( get_the_author_meta( 'display_name', $author_id ) ) . '</a></span>'
	);

	echo '<span class="posted-on meta-info">' . $posted_on . '</span><span class="byline meta-info"> ' . $byline . '</span>'; // WPCS: XSS OK.


	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link meta-info">';
		comments_popup_link( esc_html__( 'Leave a comment', 'blog-expert' ), esc_html__( '1 Comment', 'blog-expert' ), esc_html__( '% Comments', 'blog-expert' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'blog-expert' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link meta-info">',
		'</span>'
	);
}
endif;

if ( ! function_exists( 'blog_expert_entry_category' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function blog_expert_entry_category() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list('<i class="ion-ionic"></i>');
		if ( $categories_list && blog_expert_categorized_blog() ) {
			//printf( '<span class="cat-links"><span class="icon meta-icon ion-ios-folder"></span>' . esc_html__( 'Posted in %1$s', 'blog-expert' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			printf($categories_list);
		}
	}
}
endif;

if ( ! function_exists( 'blog_expert_entry_tags' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function blog_expert_entry_tags() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ',', 'blog-expert' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'blog-expert' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function blog_expert_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'blog_expert_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'blog_expert_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so blog_expert_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so blog_expert_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in blog_expert_categorized_blog.
 */
function blog_expert_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'blog_expert_categories' );
}
add_action( 'edit_category', 'blog_expert_category_transient_flusher' );
add_action( 'save_post',     'blog_expert_category_transient_flusher' );
