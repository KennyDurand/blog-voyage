<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function blog_expert_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'blog-expert' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'blog-expert' ),
		'before_widget' => '<section id="%1$s" class="widget mb-50 %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title center-widget-title"><span class="alt-bgcolor">',
		'after_title'   => '</span></h3>',
	) );

	
	register_sidebar(array(
		'name' => esc_html__('Offcanvas Panel', 'blog-expert'),
		'id' => 'slide-menu',
		'description' => esc_html__('Add widgets here.', 'blog-expert'),
		'before_widget' => '<section id="%1$s" class="widget mt-30 %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title center-widget-title"><span class="alt-bgcolor">',
		'after_title'   => '</span></h3>',
	));

	$blog_expert_footer_widgets_number = blog_expert_get_option('number_of_footer_widget');

	if( $blog_expert_footer_widgets_number > 0 ){
	    register_sidebar(array(
	        'name' => __('Footer Column One', 'blog-expert'),
	        'id' => 'footer-col-one',
	        'description' => __('Displays items on footer section.','blog-expert'),
	        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	        'after_widget' => '</aside>',
	        'before_title'  => '<h3 class="widget-title bordered-widget-title alt-textcolor">',
	        'after_title'   => '</h3>',
	    ));
	    if( $blog_expert_footer_widgets_number > 1 ){
	        register_sidebar(array(
	            'name' => __('Footer Column Two', 'blog-expert'),
	            'id' => 'footer-col-two',
	            'description' => __('Displays items on footer section.','blog-expert'),
	            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	            'after_widget' => '</aside>',
	            'before_title'  => '<h3 class="widget-title bordered-widget-title alt-textcolor">',
	            'after_title'   => '</h3>',
	        ));
	    }
	    if( $blog_expert_footer_widgets_number > 2 ){
	        register_sidebar(array(
	            'name' => __('Footer Column Three', 'blog-expert'),
	            'id' => 'footer-col-three',
	            'description' => __('Displays items on footer section.','blog-expert'),
	            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	            'after_widget' => '</aside>',
	            'before_title'  => '<h3 class="widget-title bordered-widget-title alt-textcolor">',
	            'after_title'   => '</h3>',
	        ));
	    }
	}
}
add_action( 'widgets_init', 'blog_expert_widgets_init' );
