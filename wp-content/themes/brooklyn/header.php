<?php

/*
 * The header for our theme
 * by www.unitedthemes.com
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<!--
===========================================================================
 Brooklyn WordPress Theme by United Themes (http://www.unitedthemes.com)
 Marcel Moerkens & Matthias Nettekoven 
===========================================================================
-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    
    <?php ut_meta_hook(); //action hook, see inc/ut-theme-hooks.php ?>
    
    <!-- Title -->    
    <?php if ( defined('WPSEO_VERSION') ) : ?>
		
        <title><?php wp_title(); ?></title>

	<?php else : ?>
        
    	<title><?php wp_title( '|', true, 'right' ); ?></title>
   		<meta name="description" content="<?php bloginfo('description'); ?>">
    
    <?php endif; ?>
    
    <!-- RSS & Pingbacks -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11">
    
    <!-- Favicon -->
	<?php if( ot_get_option( 'ut_favicon' ) ) : ?>
    <link rel="shortcut icon" href="<?php echo ot_get_option( 'ut_favicon' ); ?>">
    <?php endif; ?>
    
    <!-- Apple Touch Icons -->    
    <?php if( ot_get_option( 'ut_apple_touch_icon_iphone' ) ) :?>
    <link rel="apple-touch-icon" href="<?php echo ot_get_option( 'ut_apple_touch_icon_iphone' ); ?>">
    <?php endif; ?>
    
    <?php if( ot_get_option( 'ut_apple_touch_icon_ipad' ) ) : ?>
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo ot_get_option( 'ut_apple_touch_icon_ipad' ); ?>" />
    <?php endif; ?>
    
    <?php if( ot_get_option( 'ut_apple_touch_icon_iphone_retina' ) ) : ?>
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo ot_get_option( 'ut_apple_touch_icon_iphone_retina' ); ?>" />
    <?php endif; ?>
    
    <?php if( ot_get_option( 'ut_apple_touch_icon_ipad_retina' ) ) :?>
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo ot_get_option( 'ut_apple_touch_icon_ipad_retina' ); ?>" />
    <?php endif; ?>
        
    <!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]--> 
    	
    <?php wp_head(); ?>
</head>

<body id="ut-sitebody" <?php body_class(); ?>>

<a class="ut-offset-anchor" id="top" style="top:0px !important;"></a>

<?php if( ot_get_option('ut_use_image_loader') == 'on' ) : ?>
	
	<div class="ut-loader-overlay"></div>

<?php endif; ?>

<?php ut_before_header_hook(); // action hook, see inc/ut-theme-hooks.php ?> 

<?php $ut_navigation_skin = ot_get_option('ut_navigation_skin' , 'ut-header-light'); ?>

<?php

$headerstate = NULL;

if( is_home() || is_front_page() ) {
	
	if( ot_get_option('ut_navigation_state' , 'off') == 'off' ) {
		$headerstate = 'ha-header-hide';
	}

}

?>

<!-- header section -->
<header id="header-section" class="ha-header <?php echo ( ot_get_option('ut_navigation_state' , 'off') == 'on_transparent' && ( is_home() || is_front_page() ) ) ? 'ha-transparent' : $ut_navigation_skin; ?> <?php echo $headerstate; ?>">
    <div class="grid-container">
		<div class="ha-header-perspective">
        	<div class="ha-header-front">
            	
                <div class="grid-30 tablet-grid-80 mobile-grid-80">
                
					<?php if ( get_theme_mod( 'ut_site_logo' ) ) : ?>
                        
                        <div class="site-logo">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo get_theme_mod( 'ut_site_logo' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
                        </div>
                        
                    <?php else : ?>
                    
                    	<div class="site-logo">
                        	<h1 class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                        </div>
                        
                    <?php endif; ?>             	
                
                </div>    
                    
				<?php 
				
				$mainmenu = array('container'        => 'nav',
								  'container_id'     => 'navigation',
								  'fallback_cb' 	 => 'ut_default_menu',
								  'container_class'  => 'grid-70 hide-on-tablet hide-on-mobile',
								  'items_wrap'       => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								  'theme_location'   => 'primary', 
								  'walker'           => new ut_menu_walker());
										 
				$mobilemenu = array('container'        	=> 'nav',
								    'container_id'    	=> 'ut-mobile-nav',
									'menu_id'		   	=> 'ut-mobile-menu',
									'menu_class'	   	=> 'ut-mobile-menu',
								    'fallback_cb' 	   	=> 'ut_default_menu',
								    'container_class'  	=> 'ut-mobile-menu mobile-grid-100 tablet-grid-100 hide-on-desktop',
								    'items_wrap'       	=> '<div class="ut-scroll-pane"><ul id="%1$s" class="%2$s">%3$s</ul></div>',
								    'theme_location'   	=> 'primary', 
								    'walker'           	=> new ut_menu_walker());						
				
				?>
                
                <?php if ( has_nav_menu( 'primary' ) ) : ?>
                	
					<?php wp_nav_menu( $mainmenu ); ?>
                    
                    <div class="ut-mm-trigger tablet-grid-20 mobile-grid-20 hide-on-desktop">
                    	<button class="ut-mm-button"></button>
                    </div>
                    
					<?php wp_nav_menu( $mobilemenu ); ?>
                                        
                <?php endif; ?>
                                                                        
                </div>
            </div><!-- close .ha-header-perspective -->
	</div> 
</header><!-- close header -->

<div class="clear"></div>



<?php
/*
|--------------------------------------------------------------------------
| header output for blog and front page
|--------------------------------------------------------------------------
*/
?>

<?php if( is_front_page() || is_home() ) : 

$extraClass = $prefix = NULL;

/*
|--------------------------------------------------------------------------
| front page header images etc from option tree
|--------------------------------------------------------------------------
*/
if( is_front_page() ) { 
	
	$ut_custom_slogan 			= ot_get_option('ut_front_custom_slogan');
	$ut_expertise_slogan 		= ot_get_option('ut_front_expertise_slogan');
	$ut_company_slogan 	 		= ot_get_option('ut_front_company_slogan');
	$ut_scroll_to_main 	 		= ot_get_option('ut_front_scroll_to_main');
	//$ut_scroll_to_main_style	= ot_get_option('ut_front_scroll_to_main_style');
	$ut_scroll_to_main_style	= NULL; // coming with future update
	$ut_hero_overlay	 		= ot_get_option('ut_front_page_overlay');
	$ut_hero_style	 			= ot_get_option('ut_front_page_hero_style' , 'ut-hero-style-1');
	$ut_hero_align   			= ot_get_option('ut_front_page_hero_align' , 'center');
	$ut_hero_font_style			= ot_get_option('ut_front_page_hero_font_style' , 'semibold');
	$ut_hero_overlay_pattern 	= ot_get_option('ut_front_page_overlay_pattern' , 'on');
	$ut_hero_dynamic_content 	= ot_get_option('front_hero_dynamic_content');
	$pattern = ( $ut_hero_overlay_pattern == 'on' ) ? 'parallax-overlay-pattern' : '';
	$patternstyle = ot_get_option('ut_front_page_overlay_pattern_style' , 'style_one');
}

/*
|--------------------------------------------------------------------------
| blog header images etc from option tree
|--------------------------------------------------------------------------
*/
if( is_home() ) { 
	
	$ut_custom_slogan 			= ot_get_option('ut_blog_custom_slogan');
	$ut_expertise_slogan 		= ot_get_option('ut_blog_expertise_slogan');
	$ut_company_slogan 	 		= ot_get_option('ut_blog_company_slogan');
	$ut_scroll_to_main 	 		= ot_get_option('ut_blog_scroll_to_main');
	//$ut_scroll_to_main_style	= ot_get_option('ut_blog_scroll_to_main_style');
	$ut_scroll_to_main_style	= NULL; // coming with future update
	$ut_hero_overlay	 		= ot_get_option('ut_blog_overlay');
	$ut_hero_style	 			= ot_get_option('ut_blog_hero_style' , 'ut-hero-style-1');
	$ut_hero_align   			= ot_get_option('ut_blog_hero_align' , 'center');
	$ut_hero_font_style			= ot_get_option('ut_blog_hero_font_style' , 'semibold');
	$ut_hero_overlay_pattern 	= ot_get_option('ut_blog_overlay_pattern' , 'on');
	$ut_hero_dynamic_content 	= ot_get_option('blog_hero_dynamic_content');
	$pattern = ( $ut_hero_overlay_pattern == 'on' ) ? 'parallax-overlay-pattern' : '';
	$patternstyle = ot_get_option('ut_blog_overlay_pattern_style' , 'style_one');
	
}

/* header settings type slider */
if( ( is_front_page() && ot_get_option('ut_front_page_header_type') == 'slider') || ( is_home() && ot_get_option('ut_blog_header_type') == 'slider' ) ) {
	
	$extraClass = 'slider';
	
} ?>


	<?php if( ( is_front_page() && ot_get_option('ut_front_page_header_type') == 'dynamic') || ( is_home() && ot_get_option('ut_blog_header_type') == 'dynamic' ) ) : ?>
    	
        <!-- hero section -->
        <section class="ha-waypoint" data-animate-up="ha-header-hide" data-animate-down="ha-header-hide">
        
        	 <?php echo apply_filters( 'the_content' , $ut_hero_dynamic_content ); ?>
        
        </section>
    
    <?php else : ?>
    
        <!-- hero section -->
        <section class="<?php echo $extraClass; ?> hero ha-waypoint parallax-section parallax-background" data-animate-up="ha-header-hide" data-animate-down="ha-header-hide">
                
            <?php if( $ut_hero_overlay == 'on') : ?>
            
            <div class="parallax-overlay <?php echo $pattern; ?> <?php echo $patternstyle; ?>"></div> 
            
            <?php endif; ?>
            
            <?php
            /*
            |--------------------------------------------------------------------------
            | output for: image header
            |--------------------------------------------------------------------------
            */
            ?>	    
                 
            <?php if( ( is_front_page() && ot_get_option('ut_front_page_header_type') == 'image') || ( is_home() && ot_get_option('ut_blog_header_type') == 'image' ) ) : ?>
            
            <div class="grid-container">
                <!-- hero holder -->
                <div class="hero-holder grid-100 mobile-grid-100 tablet-grid-100 <?php echo $ut_hero_style; ?>">
                    <div class="hero-inner" style="text-align:<?php echo $ut_hero_align; ?>;">                
                        
                        <?php if( !empty($ut_custom_slogan) ) : ?>
                            <?php echo do_shortcode( ut_translate_meta($ut_custom_slogan) ); ?>
                        <?php endif; ?>
                        
                        <?php if( !empty($ut_expertise_slogan) ) : ?>
                            <div class="hdh"><span class="hero-description"><?php echo do_shortcode( ut_translate_meta($ut_expertise_slogan) ); ?></span></div>
                        <?php endif; ?>
                                        
                        <?php if( !empty($ut_company_slogan) ) : ?>
                            <div class="hth"><h1 class="hero-title"><?php echo do_shortcode( ut_translate_meta($ut_company_slogan) ); ?></h1></div>
                        <?php endif; ?>
                        
                        <?php if( !empty($ut_scroll_to_main) ) : ?>
                            <span class="hero-btn-holder"><a id="to-about-section" class="hero-btn <?php echo $ut_scroll_to_main_style; ?>"><?php echo ut_translate_meta($ut_scroll_to_main); ?></a></span>
                        <?php endif; ?>
                        
                    </div>
                </div><!-- close hero-holder -->
            </div>
            
            <?php endif; ?>
            
            
            <?php
            /*
            |--------------------------------------------------------------------------
            | output for: video header
            |--------------------------------------------------------------------------
            */
            ?>	    
                 
            <?php if( ( is_front_page() && ot_get_option('ut_front_page_header_type') == 'video') || ( is_home() && ot_get_option('ut_blog_header_type') == 'video' ) ) : ?>
            
            <div class="grid-container">
                <!-- hero holder -->
                <div class="hero-holder grid-100 mobile-grid-100 tablet-grid-100 <?php echo $ut_hero_style; ?>">
                    <div class="hero-inner" style="text-align:<?php echo $ut_hero_align; ?>;">                
                        
                        <?php if( !empty($ut_custom_slogan) ) : ?>
                            <?php echo do_shortcode( ut_translate_meta($ut_custom_slogan) ); ?>
                        <?php endif; ?>
                        
                        <?php if( !empty($ut_expertise_slogan) ) : ?>
                            <div class="hdh"><span class="hero-description"><?php echo do_shortcode( ut_translate_meta($ut_expertise_slogan) ); ?></span></div>
                        <?php endif; ?>
                                        
                        <?php if( !empty($ut_company_slogan) ) : ?>
                            <div class="hth"><h1 class="hero-title"><?php echo do_shortcode( ut_translate_meta($ut_company_slogan) ); ?></h1></div>
                        <?php endif; ?>
                        
                        <?php if( !empty($ut_scroll_to_main) ) : ?>
                            <span class="hero-btn-holder"><a id="to-about-section" class="hero-btn"><?php echo ut_translate_meta($ut_scroll_to_main); ?></a></span>
                        <?php endif; ?>
                        
                    </div>
                </div><!-- close hero-holder -->
            </div>
            
                <?php if( ( is_front_page() && ot_get_option('ut_video_mute_button' , 'hide') == 'show' ) || ( is_home() && ot_get_option('ut_video_mute_button_blog' , 'hide') == 'show' ) ) : ?>
                
                    <a href="#" class="ut-video-control ut-unmute">Unmute</a>
                
                <?php endif; ?>
            
            <?php endif; ?>
            
            
            <?php
            /*
            |--------------------------------------------------------------------------
            | output for: tab image header
            |--------------------------------------------------------------------------
            */
            ?>
            
            <?php if( ( is_front_page() && ot_get_option('ut_front_page_header_type') == 'tabs') || ( is_home() && ot_get_option('ut_blog_header_type') == 'tabs' ) ) : ?>
            
            <div class="grid-container">
                
                <?php /* front page settings */ ?>
                    
                <?php if( is_front_page() ) {
                    
                    $tabs_headline = ot_get_option('ut_front_page_tabs_headline');
                    $tabs = ot_get_option('ut_front_page_tabs');
                    
                } ?>
                
                <?php /* blog settings */ ?>
                
                <?php if( is_home() ) {
                    
                    $tabs_headline = ot_get_option('ut_blog_tabs_headline');
                    $tabs = ot_get_option('ut_blog_tabs');
                    
                } ?>
                
                <!-- hero holder -->
                <div class="hero-holder ut-half-height grid-100 mobile-grid-100 tablet-grid-100 <?php echo $ut_hero_style; ?>">
                    <div class="hero-inner" style="text-align:<?php echo $ut_hero_align; ?>;">                
                        
                        <?php if( !empty($ut_expertise_slogan) ) : ?>
                            <div class="hdh"><span class="hero-description"><?php echo do_shortcode( ut_translate_meta($ut_expertise_slogan) ); ?></span></div>
                        <?php endif; ?>
                                        
                        <?php if( !empty($ut_company_slogan) ) : ?>
                            <div class="hth"><h1 class="hero-title"><?php echo do_shortcode( ut_translate_meta($ut_company_slogan) ); ?></h1></div>
                        <?php endif; ?>
                        
                        <?php if( !empty($ut_scroll_to_main) ) : ?>
                            <span class="hero-btn-holder"><a id="to-about-section" class="hero-btn"><?php echo ut_translate_meta($ut_scroll_to_main); ?></a></span>
                        <?php endif; ?>
                        
                    </div>
                </div><!-- close hero-holder -->
                
                <div class="ut-tablet-holder ut-half-height hide-on-mobile">
                    
                    <div class="ut-tablet-inner">
                        
                        <div class="grid-40 suffix-5 mobile-grid-100 tablet-grid-40 tablet-suffix-5">
                            
                            <?php if( !empty( $tabs_headline ) ) : ?>
                                
                                <h2 class="ut-tablet-title"><?php echo ut_translate_meta( $tabs_headline ); ?></h2>
                                
                            <?php endif;?>
                                                
                            <?php if( !empty($tabs) && is_array($tabs) ) : ?>
                                
                                <ul class="ut-tablet-nav">
                                    
                                <?php $counter = 1; foreach($tabs as $tab) : ?>
                                            
                                    <li class="<?php echo ($counter == 1) ? 'selected' : ''; ?>"><a href="#"><?php echo $tab['title']; ?></a></li>
                            
                                <?php $counter++; endforeach; ?>
                                
                                </ul>
                            
                            <?php endif; ?>
                                
                        </div>
                        
                        <div class="grid-55 mobile-grid-100 tablet-grid-55">
                            
                            <?php if( !empty($tabs) && is_array($tabs) ) : ?>
                                
                                <ul class="ut-tablet">
                                    
                                <?php $counter = 1; foreach($tabs as $tab) : ?>
                                            
                                    <li class="<?php echo ($counter == 1) ? 'show' : ''; ?>">
                                        
                                        <?php $tab_image = ut_resize( ut_translate_meta( $tab['image'] ) , '800' , '800', true , true , true ); ?>
                                        
                                        <img src="<?php echo $tab_image; ?>" alt="<?php echo $tab['title']; ?>">
                                        
                                        <div class="ut-tablet-overlay">
                                            <div class="ut-tablet-overlay-content">
                                            <?php if( !empty( $tab['title'] ) ) : ?>
                                            
                                                <h2 class="ut-tablet-single-title"><?php echo ut_translate_meta( $tab['title'] ); ?></h2>
                                            
                                            <?php endif; ?>
                                            
                                            <?php if( !empty( $tab['description'] ) ) : ?>
                                                
                                                <p class="ut-tablet-desc"><?php echo ut_translate_meta( $tab['description'] ); ?></p>
                                                
                                            <?php endif; ?>
                                            
                                            <?php if( !empty( $tab['link_one_text'] ) ) : ?>
                                                
                                                <a class="ut-btn ut-left-tablet-button theme-btn small round" href="<?php echo ut_translate_meta( $tab['link_one_url'] ); ?>"><?php echo ut_translate_meta( $tab['link_one_text'] ); ?></a>
                                                
                                            <?php endif; ?>
                                            
                                            <?php if( !empty( $tab['link_two_text'] ) ) : ?>
                                                
                                                <a class="ut-btn ut-right-tablet-button theme-btn small round" href="<?php echo ut_translate_meta( $tab['link_two_url'] ); ?>"><?php echo ut_translate_meta( $tab['link_two_text'] ); ?></a>
                                                
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                    
                                    </li>
                            
                                <?php $counter++; endforeach; ?>
                                
                                </ul>
                                
                            <?php endif; ?>
                            
                        </div>
                
                    </div>
                    
                </div>
                
            </div>
            
            <?php endif; ?>
            
            <?php
            /*
            |--------------------------------------------------------------------------
            | output for: image slider header
            |--------------------------------------------------------------------------
            */
            ?>
            
            <?php if( (is_front_page() && ot_get_option('ut_front_page_header_type') == 'slider') || (is_home() && ot_get_option('ut_blog_header_type') == 'slider' ) ) : ?>
                            
                <?php if( is_front_page() ) {
                    
                    /* get front page slides */
                    $slides = ot_get_option('ut_front_page_slider');
                    
                } ?>
                
                <?php if( is_home() ) {
                    
                    /* get blog slides */
                    $slides = ot_get_option('ut_blog_slider');
                    
                } ?>
                
                <?php if( !empty($slides) && is_array($slides) ) : ?>
                
                    <!-- slider -->
                    <div id="ut-hero-slider" class="ut-hero-slider flexslider">
                        
                        <ul class="slides">
            
                            <?php foreach($slides as $slide) : ?>
                                            
                                <li style="background:url(<?php echo $slide['image'] ; ?>)"></li>
                            
                            <?php endforeach; ?>
            
                        </ul>
                        
                    </div>
                    <!-- close slider -->
                    
                    <!-- controls -->
                    <a class="ut-flex-control next"></a>
                    <a class="ut-flex-control prev"></a>
                    <!-- !controls -->
                    
                    <!-- caption -->
                    <div id="ut-hero-captions" class="ut-hero-captions flexslider">
                        <ul class="slides">
                            
                                <?php foreach($slides as $slide) : ?>
                                
                                    <?php 
                                    
                                    /* single caption settings */
                                    $style = ( !empty($slide['style']) && $slide['style'] != 'global') ? $slide['style'] : $ut_hero_style;
                                    $fontstyle = ( !empty($slide['font_style']) && $slide['font_style'] != 'global') ? $slide['font_style'] : $ut_hero_font_style;
                                    $animation_direction = !empty($slide['direction']) ? $slide['direction'] : 'top'; 
                                    
                                    $slidelink = !empty($slide['link']) ? $slide['link'] : '#main-content';
                                    $link_description = !empty($slide['link_description']) ? $slide['link_description'] : '';
                                    
                                    ?>                
                                
                                    <li>
                                        
                                        <div class="grid-container">
                                            <!-- hero holder -->
                                            <div class="hero-holder grid-100 mobile-grid-100 tablet-grid-100 <?php echo $style; ?>" data-animation="<?php echo $animation_direction; ?>">
                                                <div class="hero-inner">                
                                                    
                                                    <?php if( !empty($slide['expertise']) ) : ?>
                                                        <div class="hdh"><span class="hero-description"><?php echo do_shortcode( ut_translate_meta($slide['expertise']) ); ?></span></div>
                                                    <?php endif; ?>
                                                                    
                                                    <?php if( !empty($slide['description']) ) : ?>
                                                        <div class="hth"><h1 class="hero-title <?php echo $fontstyle; ?>"><?php echo do_shortcode( ut_translate_meta($slide['description']) ); ?></h1></div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if( !empty($link_description) ) : ?>
                                                        <?php $slide['link_description'] = !empty($slide['link_description']) ? $slide['link_description'] : __('Read more' , 'unitedthemes'); ?>
                                                        <span class="hero-btn-holder"><a target="_blank" href="<?php echo $slidelink; ?>" class="hero-btn hero-slider-button"><?php echo ut_translate_meta($link_description); ?></a></span>
                                                    <?php endif; ?>    
                                                                                   
                                                </div>
                                            </div><!-- close hero-holder -->
                                        </div>
                                        
                                    </li>
                                
                                <?php endforeach; ?>
                                            
                        </ul>
                    </div>
                    <!-- close captions -->
                
                <?php endif; ?> 
                 
            <?php endif; ?>        
           
            <?php
            /*
            |--------------------------------------------------------------------------
            | output for: custom header
            |--------------------------------------------------------------------------
            */
            ?>	    
                 
            <?php if( ( is_front_page() && ot_get_option('ut_front_page_header_type') == 'custom') || ( is_home() && ot_get_option('ut_blog_header_type') == 'custom' ) ) : ?>
                
                 <?php if( is_front_page() ) {
                    
                    echo do_shortcode( ot_get_option('front_hero_custom_shortcode') );
                    
                } ?>
                
                <?php if( is_home() ) {
                    
                    echo do_shortcode( ot_get_option('blog_hero_custom_shortcode') );
                    
                } ?>
            
            <?php endif; ?>
            
            <div data-section="top" class="ut-scroll-up-waypoint"></div>
            
        </section><!-- close hero section -->
    
    <?php endif; ?>

<?php endif; // end if is_home / is_front_page ?>

<div class="clear"></div>


<?php ut_before_content_hook(); // action hook, see inc/ut-theme-hooks.php ?>


<div id="main-content" class="wrap ha-waypoint" data-animate-up="ha-header-hide" data-animate-down="ha-header-small">
	
    <a class="ut-offset-anchor" id="to-main-content"></a>
		
        <div class="main-content-background">