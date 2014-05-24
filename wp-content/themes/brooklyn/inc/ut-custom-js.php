<?php

/*
 * Custom Javascript from Option Panel
 * by www.unitedthemes.com
 */


/*
|--------------------------------------------------------------------------
| Custom JS Minifier
|--------------------------------------------------------------------------
*/
add_filter( 'ut-custom-js' , 'ut_compress_java' );
if ( !function_exists( 'ut_compress_java' ) ) {

	function ut_compress_java($buffer) {
		
		/* remove comments */
		$buffer = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $buffer);
		/* remove tabs, spaces, newlines, etc. */
		$buffer = str_replace(array("\r\n","\r","\t","\n",'  ','    ','     '), '', $buffer);
		/* remove other spaces before/after ) */
		$buffer = preg_replace(array('(( )+\))','(\)( )+)'), ')', $buffer);
	
		return $buffer;
		
	}

}


if ( !function_exists( 'ut_needed_js' ) ) {
    
    function ut_needed_js() { 
        
		global $detect;
		
		$accentcolor = get_option('ut_accentcolor' , '#CC5E53');
		
        $js = '(function($){
        	
				"use strict";
		
				$(document).ready(function(){ ';
			
				/*
				|--------------------------------------------------------------------------
				| Pre Loader
				|--------------------------------------------------------------------------
				*/
                
                if( ot_get_option('ut_use_image_loader') == 'on' ) :
                	
					/* settings for pre loader */
					$loadercolor = ot_get_option( 'ut_image_loader_color' , $accentcolor );
					$barcolor = ot_get_option( 'ut_image_loader_bar_color' , $accentcolor );
					$loader_bg_color = ot_get_option('ut_image_loader_background' , '#FFF');
					$bar_height = ot_get_option('ut_image_loader_barheight', 3 );
					$ut_show_loader_bar = ot_get_option('ut_show_loader_bar' , 'on');
															
					$js .= '
					if( device.tablet() && device.mobile() ) {
						
						window.addEventListener("DOMContentLoaded", function() {
														
							$("body").queryLoader2({
								showbar: "'.$ut_show_loader_bar.'",					
								barColor: "'.$barcolor.'",
								textColor: "'.$loadercolor.'",
								backgroundColor: "'.$loader_bg_color.'",
								barHeight: '.$bar_height.',
								percentage: true,						
								completeAnimation: "fade",
								minimumTime: 500,
								onComplete : function() {
								
									$(".ut-loader-overlay").fadeOut( 600 , "easeInOutExpo" , function() {
										$(this).remove();
									});
									
								}
								
							});
						});
						
					} else {
					
						$("body").queryLoader2({						
							showbar: "'.$ut_show_loader_bar.'",			
							barColor: "'.$barcolor.'",
							textColor: "'.$loadercolor.'",
							backgroundColor: "'.$loader_bg_color.'",
							barHeight: '.$bar_height.',
							
							percentage: true,						
							completeAnimation: "fade",
							minimumTime: 500,
							onComplete : function() {
							
								$(".ut-loader-overlay").fadeOut( 600 , "easeInOutExpo" , function() {
									$(this).remove();
								});
								
							}
							
						});					
					
					}';
                
                endif;
				  
				/*
				|--------------------------------------------------------------------------
				| Slogan / Welcome Message Animation
				|--------------------------------------------------------------------------
				*/ 
				if( (is_front_page() && ot_get_option('ut_front_page_header_type') != 'slider') || (is_home() && ot_get_option('ut_blog_header_type') != 'slider') ) :
				
				$js .= '
				$(window).load(function() {
					
					function show_slogan() {
						$(".hero-holder").animate({ opacity : 1 });
					}
								
					var execute_slogan = setTimeout ( show_slogan , 800 );
					
				});'; 
				
				endif;  
				
				
				/*
				|--------------------------------------------------------------------------
				| Call to Action Button Scoll Animation
				| only available if shortcode plugin has been installed
				|--------------------------------------------------------------------------
				*/
				
				if( ut_is_plugin_active('ut-shortcodes/ut.shortcodes.php') ) {
				
				$js .= '
				$(".cta-btn a").click( function(event) { 
			
					if(this.hash) {
						$.scrollTo( this.hash , 650, { easing: "easeInOutExpo" , offset: -79 , "axis":"y" } );			
						event.preventDefault();				
					}
					
				});				
				';
				
				}
				 
				 
				                
				/*
				|--------------------------------------------------------------------------
				| Main Navigation Animation ( only for blog and front page )
				|--------------------------------------------------------------------------
				*/
               
                if( ( is_home() || is_front_page() ) && ot_get_option('ut_navigation_state' , 'off') == 'off' ) :
               	
				$ut_navigation_skin = ot_get_option('ut_navigation_skin' , 'ut-header-light');
			     
					$js .= '				
					/* Header Animation
					================================================== */		
					var $header = $( "#header-section" );
					
					$( ".ha-waypoint" ).each( function(i) {
						
						/* needed vars */
						var $this = $( this ),
							animClassDown = $this.data( "animateDown" ),
							animClassUp   = $this.data( "animateUp" );
						
						$this.waypoint(function(direction) {
							
							if( direction === "down" && animClassDown ) {
								$header.attr("class", "ha-header '.$ut_navigation_skin.' " + animClassDown );
							}
							else if( direction === "up" && animClassUp ){
								$header.attr("class", "ha-header '.$ut_navigation_skin.' " + animClassUp );
							}			
						
						}, { offset: 80 } );
						
					});';
                
                endif;
				
			    if( ( is_home() || is_front_page() ) && ot_get_option('ut_navigation_state' , 'off') == 'on_transparent' ) :
               	
					$ut_navigation_skin = ot_get_option('ut_navigation_skin' , 'ut-header-light');
					 
					$js .= '				
					/* Header Animation
					================================================== */		
					var $header = $( "#header-section" );
					
					$( "#main-content" ).waypoint(function(direction) {
							
							if( direction === "down") {
								$header.attr("class", "ha-header '.$ut_navigation_skin.' ");
							}
							else if( direction === "up"){
								$header.attr("class", "ha-header ha-transparent");
							}			
						
					}, { offset: 80 });';
                
                endif;
				
				
				/*
				|--------------------------------------------------------------------------
				| Video Player Call
				|--------------------------------------------------------------------------
				*/
				
				if( ( ( is_front_page() || is_page() ) && ot_get_option('ut_front_video_state') == 'on' ) || ( ( is_home() || is_single() ) && ot_get_option('ut_blog_video_state') == 'on' ) ) :				
					
					if( !$detect->isMobile() && !$detect->isTablet() ) :
					
						$js .= '
						$(".ut-video-player").mb_YTPlayer();
						
						/* player mute control */
						$(".ut-video-control").click(function(event){
							
							event.preventDefault();		
							
							if( $(".ut-video-control").hasClass("ut-unmute") ) {
								
								$(this).removeClass("ut-unmute").addClass("ut-mute").text("MUTE");														
								$(".ut-video-player").unmuteYTPVolume();
								$(".ut-video-player").setYTPVolume(5);
								
							} else {
								
								$(this).removeClass("ut-mute").addClass("ut-unmute").text("UNMUTE");
								$(".ut-video-player").muteYTPVolume();							
								
							}

						});';					
					
					endif;
					
               	endif;
				
				/*
				|--------------------------------------------------------------------------
				| Slider Settings Hook
				|--------------------------------------------------------------------------
				*/ 
				if( ( is_front_page() && ot_get_option('ut_front_page_header_type') == 'slider' ) || ( is_home() && ot_get_option('ut_blog_header_type') == 'slider') ) : 
           			
					/* slider options front page */
					if( is_front_page() ) {
						
						$animation		= ot_get_option('front_animation' , 'fade');
						$slideshowSpeed = ot_get_option('front_slideshow_speed' , 7000);
						$animationSpeed = ot_get_option('front_animation_speed' , 600);
						
					}
					
					/* slider options blog */
					if( is_home() ) {
						
						$animation		= ot_get_option('blog_animation', 'fade');
						$slideshowSpeed = ot_get_option('blog_slideshow_speed' , 7000);
						$animationSpeed = ot_get_option('blog_animation_speed' , 600);
			
					} 
                
                 $js .= '
				 $(window).load(function(){
					 
					 var $hero_captions = $("#ut-hero-captions"),
					 	 animatingTo = 0;
					 
					 $hero_captions.find(".hero-holder").each(function() {						
						
						var pos = $(this).data("animation"),
							add = "-50%";
						
						if( pos==="left" || pos==="right" ) { add = "-25%" };						
						
						$(this).css( pos , add );	
												
					 });
					 
					 
                     $hero_captions.flexslider({
                        animation: "fade",
						animationSpeed: 1000,
                        controlNav: false,
						directionNav: false,
                        animationLoop: true,
                        slideshow: true,
                        before: function(slider){                        	
							
							/* hide hero holder */
							$(".flex-active-slide").find(".hero-holder").fadeOut("fast", function() {
								
								var pos = $(this).data("animation"),
									anim = { opacity: 0 , display : "table" },
									add = "-50%";
								
								if( pos==="left" || pos==="right" ) { add = "-25%" };
								
								anim[pos] = add;
								
								$(this).css(anim);
								
							});
														
							/* animate background slider */
                            $("#ut-hero-slider").flexslider(slider.animatingTo);
						    
                        },
						after: function(slider) {
							
							/* change position of caption slider */
							slider.animate( { top : ( $(window).height() - $hero_captions.find(".flex-active-slide").height() ) / 2 } , 100 , function() {
							
								/* show hero holder */
								var pos = $(".flex-active-slide").find(".hero-holder").data("animation"),
									anim = { opacity: 1 };
								
								anim[pos] = 0;
								
								$(".flex-active-slide").find(".hero-holder").animate( anim );
							
							});
														
						},
						start: function(slider) {
							 
							/* create external navigation */
							$(".ut-flex-control").click(function(event){
								
								if ($(this).hasClass("next")) {
								
								  slider.flexAnimate(slider.getTarget("next"), true);
								
								} else {
								
								  slider.flexAnimate(slider.getTarget("prev"), true);
								
								}
								
								event.preventDefault();	
								
							});
							
							$(".hero.slider .parallax-overlay").fadeIn("fast");
														
							/* change position of caption slider */
							slider.animate( { top : ( $(window).height() - $hero_captions.find(".flex-active-slide").height() ) / 2 } , 100 , function() { 
								
								/* apply fittext */
								slider.find(".hero-title").fitText(0.8, { minFontSize: "30px", maxFontSize: "70px" }).trigger("resize");

								/* show hero holder */
								var pos = $(".flex-active-slide").find(".hero-holder").data("animation"),
									anim = { opacity: 1 };
					
								anim[pos] = 0;
									
								$(".flex-active-slide").find(".hero-holder").animate( anim );
							
							
							});
														
						}
					});
                    
					$(window).resize(function(){
						$hero_captions.flexslider(animatingTo);
					});
										
                    $("#ut-hero-slider").flexslider({
						animation: "fade",
						animationSpeed: 1000, 
                        directionNav: false,
						controlNav: false,
    					animationLoop: false,
                        slideshow: false
					});
                    
                    
				});';
                
                endif;
				
				
				/*
				|--------------------------------------------------------------------------
				| Parallax Effect for Header on Front Page
				|--------------------------------------------------------------------------
				*/ 
				
				$ut_front_header_parallax = ot_get_option('ut_front_header_parallax' , 'on'); 
				
				if( is_front_page() && $ut_front_header_parallax == 'on' ) :
                
                	$js .= '
					if( !device.tablet() && !device.mobile() ) {
						$(".hero.parallax-section").addClass("fixed").parallax("50%", 0.6);
					}
					';
                
                endif;
				
				
				/*
				|--------------------------------------------------------------------------
				| Parallax Effect for Header on Blog
				|--------------------------------------------------------------------------
				*/ 
				
				$ut_blog_header_parallax = ot_get_option('ut_blog_header_parallax' , 'on');
                
                if( is_home() && $ut_blog_header_parallax == 'on' ) :
                
                	$js .= '
					if( !device.tablet() && !device.mobile() ) {
						$(".hero.parallax-section").addClass("fixed").parallax("50%", 0.6);
					}
					';
                
                endif;
                
                
                /*
				|--------------------------------------------------------------------------
				| Parallax Effect for Footer
				|--------------------------------------------------------------------------
				*/ 
                               
                $ut_csection_parallax = ot_get_option('ut_csection_parallax' , 'on'); 
				
				if( $ut_csection_parallax == 'on' ) : 
                
                	$js .= '
					if( !device.tablet() && !device.mobile() ) {
						$(".contact-section.parallax-section").addClass("fixed").parallax("50%", 0.6,true);
					}
					';
                
                endif;
				
				
				/*
				|--------------------------------------------------------------------------
				| Section Animation
				|--------------------------------------------------------------------------
				*/
				
				global $detect;
				
				if( !$detect->isMobile() && !$detect->isTablet() && ot_get_option('ut_animate_sections' , 'on') == 'on' ) : 
				
						$js .= '$("section").each(function() {
								
								var container 	= $(this).attr("id"),
									timer 		= 200,
									outerHeight = $(this).outerHeight(),
									offset		= "90%";
								
								if( outerHeight > $(window).height() / 2 ) {
									offset = "70%";
								}
								
								$(this).waypoint( function( direction ) {
													
									if( direction === "down" && !$(this).hasClass("animated") ) {
										
										if( $("#"+container).find(".section-title").length || $("#"+container).find(".parallax-title").length ) {
									
											setTimeout ( function () {
																					
													$("#"+container).find(".section-title").animate({ opacity: 1 }  , 600 , "easeInOutExpo" );
													$("#"+container).find(".parallax-title").animate({ opacity: 1 } , 600 , "easeInOutExpo" );							
																					
											}, timer );
											
											/* increase timer for next function */
											timer = timer + 200;
																
										}
										
										
										if( $("#"+container).find(".lead").length ) {
										
											setTimeout ( function () {
																					
													$("#"+container).find(".lead").animate({ opacity: 1 } , 600 , "easeInOutExpo" );
																					
											}, timer );
											
											timer = timer + 200;
																
										}
										
										if( $("#"+container).find(".section-content").length || $("#"+container).find(".parallax-content").length ) {
															
											setTimeout ( function () {
																					
													$("#"+container).find(".section-content").animate({ opacity: 1 }  , 1000 , "linear" );
													$("#"+container).find(".parallax-content").animate({ opacity: 1 } , 1000 , "linear" );
																					
											}, timer , true );	
											
										}
										
										$(this).addClass("animated");
											
									}
									
								} , { offset: offset } );			
								
						});';             
            	
				endif;
					                
            $js .= '});
			
        })(jQuery);';
		
		echo apply_filters( 'ut-custom-js' , $js );
                
    }
    
    add_action( 'ut_java_footer_hook', 'ut_needed_js', 100 );

}