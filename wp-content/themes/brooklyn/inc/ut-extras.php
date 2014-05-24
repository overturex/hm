<?php

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
if ( !function_exists( 'unitedthemes_page_menu_args' ) ) { 
	
	function unitedthemes_page_menu_args( $args ) {
		$args['show_home'] = true;
		return $args;
	}
	add_filter( 'wp_page_menu_args', 'unitedthemes_page_menu_args' );
	
}

/**
 * Adds custom classes to the array of body classes.
 */
if ( !function_exists( 'unitedthemes_body_classes' ) ) {  

	function unitedthemes_body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}
	
		return $classes;
	}
	add_filter( 'body_class', 'unitedthemes_body_classes' );
	
}

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
if ( !function_exists( 'unitedthemes_enhanced_image_navigation' ) ) { 

	function unitedthemes_enhanced_image_navigation( $url, $id ) {
		if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
			return $url;
	
		$image = get_post( $id );
		if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
			$url .= '#main';
	
		return $url;
	}
	add_filter( 'attachment_link', 'unitedthemes_enhanced_image_navigation', 10, 2 );
	
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
if ( !function_exists( 'unitedthemes_wp_title' ) ) {  

	function unitedthemes_wp_title( $title, $sep ) {
		global $page, $paged;
	
		if ( is_feed() )
			return $title;
	
		// Add the blog name
		$title .= get_bloginfo( 'name' );
	
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title .= " $sep $site_description";
	
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			$title .= " $sep " . sprintf( __( 'Page %s', 'unitedthemes' ), max( $paged, $page ) );
	
		return $title;
	}
	add_filter( 'wp_title', 'unitedthemes_wp_title', 10, 2 );
	
}



/**
 * let read more jump to article top
 */
if ( !function_exists( 'ut_remove_more_link_scroll' ) ) {  

	function ut_remove_more_link_scroll( $link ) {
		$link = preg_replace( '|#more-[0-9]+|', '', $link );
		return $link;
	}
	
	add_filter( 'the_content_more_link', 'ut_remove_more_link_scroll' );
	
}

/**
 * poster image for video backgrounds
 */
if ( !function_exists( 'ut_create_poster_image' ) ) {  

	function ut_create_poster_image() {
		
		global $detect;
		
		$poster = NULL;
		
		if( ( ( is_front_page() || is_page() ) && ot_get_option('ut_front_video_state') == 'on' ) || ( ( is_home() || is_single() ) && ot_get_option('ut_blog_video_state') == 'on' ) ) :
			
			if( $detect->isMobile() || $detect->isTablet() ) :
				
				$poster = '<div class="ut-video-poster normal-background"></div>';
				
			endif;
			
		endif;
		
		echo $poster;
		
	}
	
	add_action('ut_before_header_hook', 'ut_create_poster_image' , 100 );
	
}