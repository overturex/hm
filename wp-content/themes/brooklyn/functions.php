<?php

/*
 * Basic functions 
 * by www.unitedthemes.com
  */

/*
|--------------------------------------------------------------------------
| default theme constants & repeating variables
| * do not change
|--------------------------------------------------------------------------
*/ 

define('UT_THEME_NAME', 'Brooklyn');
define('UT_THEME_VERSION', '2.2');

define('THEME_WEB_ROOT', get_template_directory_uri() );
define('THEME_DOCUMENT_ROOT', get_template_directory() );

define('STYLE_WEB_ROOT', get_stylesheet_directory_uri() );
define('STYLE_DOCUMENT_ROOT', get_stylesheet_directory() );


/* activates all admin features of option tree */
define('UT_DEV_MODE', false );

/*
|--------------------------------------------------------------------------
| Plugin Install and Update Notification
|--------------------------------------------------------------------------
*/
if( is_admin() ){
    include_once( THEME_DOCUMENT_ROOT . '/inc/ut-theme-activation.php' );
}

/*
|--------------------------------------------------------------------------
| Option Tree Integration
|--------------------------------------------------------------------------
*/

/* helper function to detect already installed plugin */
if ( !function_exists( 'ut_is_plugin_active' ) ) {
	
	function ut_is_plugin_active( $plugin ) {
		return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
	}
	
}

/* only include these files if option tree is not active as a plugin */
if( !ut_is_plugin_active('option-tree/ot-loader.php') ) {

	add_filter( 'ot_show_new_layout', '__return_true' ); // activate layout management
	add_filter( 'ot_theme_mode', '__return_true' ); // acitvate theme mode
	
	if( !UT_DEV_MODE ) {
		add_filter( 'ot_show_pages', '__return_false' ); // hide ot docs & settings
	}
	
	include_once( THEME_DOCUMENT_ROOT . '/admin/ot-loader.php' );
	include_once( THEME_DOCUMENT_ROOT . '/admin/one-page-settings.php' );
	include_once( THEME_DOCUMENT_ROOT . '/admin/ut-admin-loader.php' );
	include_once( THEME_DOCUMENT_ROOT . '/admin/theme-options.php' );
	include_once( THEME_DOCUMENT_ROOT . '/admin/includes/ut-google-fonts.php' );
	
} else {
	
	function ut_notify_user_ot_detected() {
		
		$alert = '<div class="ut-alert red" style="position:fixed; z-index:9999; width:100%; text-align:center;">';
			$alert .= __('Option Tree Plugin has been detected! Please deactivate this Plugin to prevent themecrashes and failures!', 'unitedthemes' );
	 	$alert .= '</div>';
		
		echo $alert;
		
	}
	
	/* display user information on front page with the help of the ut_before_header_hook */
	add_action( 'ut_before_header_hook', 'ut_notify_user_ot_detected' );

}

if( is_admin() ){
	
	/* theme info page - displays information for support inquiries */
	include_once( THEME_DOCUMENT_ROOT . '/admin/themeinfo/index.php' );
	
	/* theme demo importer */
	include_once( THEME_DOCUMENT_ROOT . '/admin/ut-demo-importer.php' );
	
}

/*
|--------------------------------------------------------------------------
| Default Content Width
|--------------------------------------------------------------------------
*/
if ( !isset( $content_width ) ) {
    $content_width = 1170; /* pixels */
}

/*
|--------------------------------------------------------------------------
| Load required files
|--------------------------------------------------------------------------
*/
include_once( THEME_DOCUMENT_ROOT . '/inc/ut-theme-hooks.php' );
include_once( THEME_DOCUMENT_ROOT . '/inc/ut-image-resize.php' );
include_once( THEME_DOCUMENT_ROOT . '/inc/ut-theme-postformat-tools.php' );
include_once( THEME_DOCUMENT_ROOT . '/inc/ut-theme-gallery.php' );
include_once( THEME_DOCUMENT_ROOT . '/inc/ut-prepare-front-page.php' );
include_once( THEME_DOCUMENT_ROOT . '/inc/ut-menu-walker.php' );

/* Mobile Detect */
if ( ! class_exists('Mobile_Detect') ) { 
	
	include_once( THEME_DOCUMENT_ROOT . '/inc/lib/ut-mobile-detect-class.php' );
	$detect = new Mobile_Detect();

}

/* can be placed within the child theme */
if( file_exists( STYLE_DOCUMENT_ROOT . '/inc/ut-custom-css.php' ) ) {
	
	/* file inside child theme */
	include_once( STYLE_DOCUMENT_ROOT . '/inc/ut-custom-css.php' ) ;

} else {
	
	/* file inside main theme */
	include_once( THEME_DOCUMENT_ROOT . '/inc/ut-custom-css.php' ) ;	
	
}

/* can be placed within the child theme */
if( file_exists( STYLE_DOCUMENT_ROOT . '/inc/ut-custom-js.php' ) ) {
	
	/* file inside child theme */
	include_once( STYLE_DOCUMENT_ROOT . '/inc/ut-custom-js.php' );

} else {
	
	/* file inside main theme */
	include_once( THEME_DOCUMENT_ROOT . '/inc/ut-custom-js.php' );
	
}


/*
|--------------------------------------------------------------------------
| Load Theme Setup
|--------------------------------------------------------------------------
*/

add_action( 'after_setup_theme', 'unitedthemes_setup' );

if ( ! function_exists( 'unitedthemes_setup' ) ) :

    /**
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     */

    function unitedthemes_setup() {

        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         * If you're building a theme based on unitedthemes, use a find and replace
         * to change 'unitedthemes' to the name of your theme in all the template files
		 * we recommend to place the language files inside the child theme
         */
         
        load_theme_textdomain( 'unitedthemes' , STYLE_DOCUMENT_ROOT . '/admin/languages' );
    			
        /**
         * Add default posts and comments RSS feed links to head
         */
        add_theme_support( 'automatic-feed-links' );
    
        /**
         * Enable support for Post Thumbnails on posts and pages
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support( 'post-thumbnails' , array( 'post' , 'page' , 'portfolio') );
		add_image_size( 'blog-default', '806', '300', true);
		
		
        /**
         * This theme uses wp_nav_menu() in one location.
         */
        register_nav_menus( array(
            'primary' 		=> __( 'Primary Menu', 'unitedthemes' )
        ) );
    
	
        /**
         * Enable support for Post Formats
         */
        add_theme_support( 'post-formats', array( 'image', 'video', 'quote', 'link', 'gallery' ) );	
		add_post_type_support( 'portfolio', 'post-formats' );
		
    }
    
endif; // unitedthemes_setup

/*
|--------------------------------------------------------------------------
| Register widgetized area and update sidebar with default widgets
|--------------------------------------------------------------------------
*/
if ( ! function_exists( 'unitedthemes_widgets_init' ) ) :
 
    function unitedthemes_widgets_init() {
        
		if (function_exists( 'ot_get_option') ) {
            
			$sidebars = ot_get_option( 'ut_sidebars', '', false, true, -1 );
                
				if( !empty( $sidebars ) && is_array( $sidebars ) ){
                
				foreach( $sidebars as $num => $sidebar_options ){
                    
					register_sidebar(array(
                        'name'              => $sidebar_options['title'],
                        'id'                => 'ut_sidebar_' . $sidebar_options['ut_sidebar_id'],
                        'description'       => $sidebar_options['ut_sidebardesc'],
                        'before_widget'     => '<li id="%1$s" class="clearfix widget-container %2$s">',
                        'after_widget'         => '</li>',
                        'before_title'         => '<h3 class="widget-title"><span>',
                        'after_title'         => '</span></h3>',
                    ));
					
                }   
            }			
        }
		
		register_sidebar( array(
            'name' => __( 'Blog Sidebar', 'unitedthemes' ),
            'id' => 'blog-widget-area',
            'before_widget' => '<li class="clearfix widget-container %1$s %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ) );
		
    }
    
    add_action( 'widgets_init', 'unitedthemes_widgets_init' );

endif;


/*
|--------------------------------------------------------------------------
| include all custom widgets
|--------------------------------------------------------------------------
*/
foreach ( glob( dirname(__FILE__)."/widgets/*.php" ) as $filename ){
    include_once( $filename );
}


/*
|--------------------------------------------------------------------------
| Enqueue scripts and styles
|--------------------------------------------------------------------------
*/
if ( ! function_exists( 'unitedthemes_scripts' ) ) :

    function unitedthemes_scripts() {
        
		/*
		|--------------------------------------------------------------------------
		| CSS
		|--------------------------------------------------------------------------
		*/
		
        /* Fonts */
		wp_enqueue_style( 'main-font-face', 	STYLE_WEB_ROOT . '/css/ut-fontface.css' );
		wp_enqueue_style( 'ut-fontawesome', 	STYLE_WEB_ROOT . '/css/font-awesome.css' );
		
		/* Google Fonts */
		ut_create_google_font_link();
				
        /* Grid and Responsive */
        wp_enqueue_style( 'ut-responsive-grid', STYLE_WEB_ROOT . '/css/ut-responsive-grid.css' );
        		
		/* Flexslider */
		wp_enqueue_style( 'ut-flexslider', 		STYLE_WEB_ROOT . '/css/flexslider.css' );
		
		/* Prettyphoto */
		wp_enqueue_style( 'ut-prettyphoto', 	STYLE_WEB_ROOT . '/css/prettyPhoto.css' );
		
		/* Main Navigation */
		wp_enqueue_style( 'ut-superfish' , 		STYLE_WEB_ROOT . '/css/ut-superfish.css' );
		
		/* Main CSS */
        wp_enqueue_style( 'unitedthemes-style' , get_stylesheet_uri() );
		
		/*
		|--------------------------------------------------------------------------
		| JavaScript
		|--------------------------------------------------------------------------
		*/	
				
		/* base javaScripts header */
        wp_enqueue_script( 'jquery' );
		
		/* preloader */
		if( ot_get_option('ut_use_image_loader') == 'on' ) {
			
			wp_enqueue_script( 'ut-loader'	,		STYLE_WEB_ROOT . '/js/jquery.queryloader2.min.js', array('jquery'), '2.6' , false ); 
			
		}	
		
		/* browser and mobile detection */
		wp_enqueue_script( 'device-detect'  , THEME_WEB_ROOT . '/js/device.min.js', array('jquery') , '0.1.57' );
		wp_enqueue_script( 'modernizr' 		, THEME_WEB_ROOT . '/js/modernizr.min.js', array('jquery') , '2.6.2' );
						
		/* comment reply*/
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }        
		
		/* 
		 * base Java Scripts // output in footer 
		 */
		
		/* toucheffect js */
		wp_enqueue_script( 'ut-toucheffects',	STYLE_WEB_ROOT . '/js/toucheffects.min.js', array('jquery'), '1.0' , true );
				
		/* easing */
		wp_enqueue_script( 'ut-easing'		,	STYLE_WEB_ROOT . '/js/jquery.easing.min.js', array('jquery'), '1.3' , true );
		
		/* superfish navigation */
		wp_enqueue_script( 'ut-superfish'	,	STYLE_WEB_ROOT . '/js/superfish.min.js', array('jquery'), '1.7.4' , true ); 	
		
		/* smothscroll especially for chrome */
		if(preg_match("/chrome/",strtolower($_SERVER['HTTP_USER_AGENT']))) {
			wp_enqueue_script( 'ut-smoothscroll',	STYLE_WEB_ROOT . '/js/SmoothScroll.min.js', array('jquery'), '0.9.9' , true ); 	
		}
		
		/* retina images */
		wp_enqueue_script( 'ut-retina'	,		STYLE_WEB_ROOT . '/js/retina.min.js', array('jquery'), '1.1' , true );
		
		/* background video player */
		wp_enqueue_script( 'ut-bgvid'	,		STYLE_WEB_ROOT . '/js/jquery.mb.YTPlayer.min.js', array('jquery'), '1.0' , true ); 
		
		/* flexslider for slider headers */
		wp_enqueue_script( 'ut-flexslider-js' , STYLE_WEB_ROOT . '/js/jquery.flexslider.min.js', '2.2.0' , true ); 
		
		/* parallax for section backgrounds */
		wp_enqueue_script( 'ut-parallax',		STYLE_WEB_ROOT . '/js/jquery.parallax.min.js', array('jquery'), '1.1.3' , true );
		
		/* scroll to section */
		wp_enqueue_script( 'ut-scrollTo',		STYLE_WEB_ROOT . '/js/jquery.scrollTo.min.js', array('jquery'), '1.4.6' , true );		
		
		/* simple waypoints */
		wp_enqueue_script( 'ut-waypoints',		STYLE_WEB_ROOT . '/js/jquery.waypoints.min.js', array('jquery'), '2.0.2' , true );
		
		/* prettyphoto */
		wp_enqueue_script( 'ut-prettyphoto',	STYLE_WEB_ROOT . '/js/jquery.prettyPhoto.min.js', array('jquery'), '3.1.5' , true );
		
		/* Fit Vid for embeded videos*/	
		wp_enqueue_script( 'ut-fitvid'	,		STYLE_WEB_ROOT . '/js/jquery.fitvids.min.js', array('jquery'), '1.0.3' , true );
		
		/* fit text */
		wp_enqueue_script( 'ut-fittext'	,		STYLE_WEB_ROOT . '/js/jquery.fittext.min.js', array('jquery'), '1.1' , true );
		
		/* Custom JavaScripts - you can use this file inside the child theme or use the footer java hook */
        wp_enqueue_script( 'unitedthemes-init', STYLE_WEB_ROOT . '/js/ut-init.js', array('jquery'), UT_THEME_VERSION , TRUE );
		
    
    }
    
    add_action( 'wp_enqueue_scripts', 'unitedthemes_scripts' );

endif;

/*
|--------------------------------------------------------------------------
| Custom template tags for this theme
|--------------------------------------------------------------------------
*/
require get_template_directory() . '/inc/ut-template-tags.php';


/*
|--------------------------------------------------------------------------
| Custom functions that act independently of the theme templates.
|--------------------------------------------------------------------------
*/
require get_template_directory() . '/inc/ut-extras.php';


/*
|--------------------------------------------------------------------------
| WordPress Customizer
|--------------------------------------------------------------------------
*/
require get_template_directory() . '/inc/ut-customizer.php';


/*
|--------------------------------------------------------------------------
| Recognized Font Families
|--------------------------------------------------------------------------
*/

if ( !function_exists( 'ut_recognized_font_styles' ) ) {

	function ut_recognized_font_styles() {
	  
	  return apply_filters( 'ut_recognized_font_styles', array(
			"extralight" 		=> "ralewayextralight",
			"light" 			=> "ralewaylight",
			"regular"	 		=> "ralewayregular",
			"medium"			=> "ralewaymedium",
			"semibold"			=> "ralewaysemibold",
			"bold"				=> "ralewaybold"		
	  ));
	  
	}
	
}

if ( !function_exists( 'ut_recognized_families' ) ) {

	function ut_recognized_font_families( $basefonts ) {
	  	  
	  	$newfonts = array(
				"ralewayextralight" 	=> "Raleway Extralight",
				"ralewaylight" 			=> "Raleway Light",
				"ralewayregular"	 	=> "Raleway Regular",
				"ralewaymedium"			=> "Raleway Medium",
				"ralewaysemibold"		=> "Raleway Semibold",
				"ralewaybold"			=> "Raleway Bold"		
		);
		
		$basefonts = array_merge($basefonts , $newfonts);
		return $basefonts;
	  
	}
	
}

//add_filter('ot_recognized_font_families' , 'ut_recognized_font_families');


/*
|--------------------------------------------------------------------------
| Custom Search Form 
| due to WP echo on get_search_form Bug we need to make use a filter
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_searchform_filter' ) ) {

    function ut_searchform_filter( $form ) {

    $searchform = '<form role="search" method="get" class="search-form" id="searchform" action="' . esc_url( home_url( '/' ) ) . '">
        <label>
            <span>' .__( 'Search for:' , 'unitedthemes' ) . '</span>
            <input type="search" class="search-field" placeholder="' .esc_attr__( 'To search type and hit enter' , 'unitedthemes' ) . '" value="' . esc_attr( get_search_query() ) . '" name="s" title="' . __( 'Search for:' , 'unitedthemes' ) . '">
        </label>
        <input type="submit" class="search-submit" value="' . esc_attr__( 'Search' , 'unitedthemes' ) . '">
        </form>';
        
        return $searchform; 
    }
    
    add_filter( 'get_search_form', 'ut_searchform_filter' );

}

/*
|--------------------------------------------------------------------------
| some editor styles to reflect page style inside tinymce  
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_add_editor_styles' ) ) {

	function ut_add_editor_styles() {
		add_editor_style( 'ut-editor.css' );
	}
	add_action( 'init', 'ut_add_editor_styles' );
	
}


/*
|--------------------------------------------------------------------------
| helper function : return image ID by URL
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_get_image_id' ) ) {
	
	function ut_get_image_id($image_url) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $image_url )); 
			return $attachment[0]; 
	}

}

/*
|--------------------------------------------------------------------------
|  helper function : return true if current page is blog related
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_is_blog_related' ) ) {
	
    function ut_is_blog_related() {
	
		return ( is_tag() || is_search() || is_archive() || is_category() ) ? true : false;
		
	}
    
}

/*
|--------------------------------------------------------------------------
| helper function : returns needed meta data of the current page
|--------------------------------------------------------------------------
*/

if( !function_exists('ut_return_meta') ) {

	function ut_return_meta( $ID = '' ) {
		
        global $post, $wp_query;
        
		// woo commerce shop ID
		if( function_exists('is_shop') ) {
			
			if( is_shop() ) {
				$pageID = get_option('woocommerce_shop_page_id');
			}
			
		}
		
		// blog page ID
		if( is_home() || ut_is_blog_related() ) {
			
			$pageID = get_option('page_for_posts');
		
		// all other pages
		} else {
			
			$pageID = ( isset($wp_query->post) ) ? $wp_query->post->ID : NULL;
            
		}
        
		return get_post_meta( $pageID );
	
	}
		
}


/*
|--------------------------------------------------------------------------
| helper function : fix wordpress w3c rel
|--------------------------------------------------------------------------
*/

if( !function_exists('ut_replace_cat_tag') ) {
	
	function ut_replace_cat_tag ( $text ) {
		$text = preg_replace('/rel="category tag"/', 'data-rel="category tag"', $text); return $text;
	}
	add_filter( 'the_category', 'ut_replace_cat_tag' );
	
}


/*
|--------------------------------------------------------------------------
| helper function : default menu output
|--------------------------------------------------------------------------
*/
if( !function_exists('ut_default_menu') ) {
	function ut_default_menu() {
		require_once ( THEME_DOCUMENT_ROOT . '/inc/default-menu.php');
	}
}


/*
|--------------------------------------------------------------------------
| helper function : QTranslate Quicktags Support for Meta and Theme Options
|--------------------------------------------------------------------------
*/
if ( ! function_exists( 'ut_translate_meta' ) ) :
	
    function ut_translate_meta($content) {
    	
        if( function_exists ( 'qtrans_useCurrentLanguageIfNotFoundShowAvailable' ) ) {
            $content = qtrans_useCurrentLanguageIfNotFoundShowAvailable($content);
        }
        
        return $content;
    }
    
endif;

/*
|--------------------------------------------------------------------------
| helper function : Create Google Font URL
|--------------------------------------------------------------------------
*/
if ( ! function_exists( 'ut_create_google_font_link' ) ) :
	
    function ut_create_google_font_link() {
    	
		global $wpdb;
		
		/* needed vars */
		$google_url = 'http://fonts.googleapis.com/css?family=';
				
		/* available google fonts */
		$google_fonts = ut_recognized_google_fonts();
		
		/* cache for all google typography settings */
		$option_keys = array();
		
		/* custom array of all affected option tree options */
		$google_options = array(
			
			'ut_body_font_type' 			=> 'ut_google_body_font_style',
			'ut_blockquote_font_type'		=> 'ut_google_blockquote_font_style',
			'ut_front_hero_font_type'		=> 'ut_google_front_page_hero_font_style',
			'ut_blog_hero_font_type'		=> 'ut_google_blog_hero_font_style',
			'ut_global_headline_font_type'  => 'ut_global_google_headline_font_style',
			'ut_global_lead_font_type'		=> 'ut_google_lead_font_style',
			'ut_global_h1_font_type'		=> 'ut_h1_google_font_style',
			'ut_global_h2_font_type'		=> 'ut_h2_google_font_style',
			'ut_global_h3_font_type'		=> 'ut_h3_google_font_style',
			'ut_global_h4_font_type'		=> 'ut_h4_google_font_style',
			'ut_global_h5_font_type'		=> 'ut_h5_google_font_style',
			'ut_global_h6_font_type'		=> 'ut_h6_google_font_style',
			'ut_csection_header_font_type'	=> 'ut_csection_header_google_font_style'			
		
		);
		
		/* fill option keys */
		foreach( $google_options as $key => $google_option) {
			
			if( ot_get_option( $key , 'ut-font' ) == 'ut-google' ) {
				
				$option_keys[$key] = ot_get_option($google_option);
			
			}
			
		}
				
		/* query meta values */
		/* $meta_keys = $wpdb->get_results( $wpdb->prepare("
			SELECT p.ID, pm.meta_value FROM {$wpdb->postmeta} pm
			LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			WHERE pm.meta_key = '%s' 
			AND p.post_type = '%s'
		", 'ut_section_header_font_type' , 'page')); */		
		
		/* create query string */		
		foreach( $option_keys as $option ) {
			
			if( !empty($google_fonts[$option['font-id']]) ) {
				
				$query_string = '';
				
				/* replace whitespace with + */
				$family = preg_replace("/\s+/" , '+' , $google_fonts[$option['font-id']]['family'] );
				
				/* build string */
				$query_string = $family.':'.( !empty($option['font-weight']) ? $option['font-weight'] : '' ).( !empty($option['font-style']) ? $option['font-style'] : '' ).( !empty($option['font-subset']) ? '&amp;subset='.$option['font-subset'] : '' );
				
				wp_enqueue_style( 'ut-'.$family , $google_url . $query_string );

					
			}
					
		}
		
    }
    
endif;