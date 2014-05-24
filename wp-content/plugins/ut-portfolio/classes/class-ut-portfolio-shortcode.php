<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

if( !function_exists('ut_generate_cat_list') ) :

	function ut_generate_cat_list( $categories , $separator = "," ) {
		
		if(!is_array($categories)) {
			return;
		}
		
		$return = '';
		$cats = count( $categories );
		$counter = 1;
		
		foreach( $categories as $category ) {
			
			$return .= $category->name;
			
			if( $counter < $cats) {
				$return .= $separator.' ';
			}
			
			$counter++;
			
		}
		
		return $return;
		
	}

endif;

/*
|--------------------------------------------------------------------------
| Video Portfolio Post
|--------------------------------------------------------------------------
*/
if( !function_exists('get_portfolio_format_video_content') ) {

    function get_portfolio_format_video_content( $content ) {
        
        /* needed variables */
        $videofound = false;        
		$value = ut_portfolio_url_grabber( $content );
			            
        if( !empty( $value ) ) {
            
            /* set video found */
            $videofound = true;
            
        }
                
        /* we have a meta value , lets check its syntax and return it */
        if( $videofound ) {
        
            if ( is_numeric( $value ) ) {
                
                $video = wp_get_attachment_url( $value );
                return do_shortcode( sprintf( '[video src="%s"]', $video ) );
                
            } elseif ( preg_match( '/' . get_shortcode_regex() . '/s', $value ) ) {

                return do_shortcode( $value );
                
            } else {
                
                return $value;
                
            }
        }
    }
}


if(!function_exists('ut_portfolio_url_grabber')) {
 
    function ut_portfolio_url_grabber( $string ) {
    
        $imageurl = !empty( $string ) ? preg_match_all('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', $string , $match) : '';
        return isset($match[0][0]) ? ut_portfolio_add_http($match[0][0]) : '';
    
    }
    
}

if(!function_exists('ut_portfolio_add_http')) {

	function ut_portfolio_add_http($url) {
		
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
		}
		return esc_url_raw($url);
	}
	
}


/*
|--------------------------------------------------------------------------
| Slider Portfolio Post
|--------------------------------------------------------------------------
*/
if( !function_exists('ut_portfolio_flex_slider') ) {

    function ut_portfolio_flex_slider( $postID , $singular = false , $image_style = "ut-square" ) {
                                                        
        /* get all necessary image ID's */
        $ut_gallery_images = ut_portfolio_extract_gallery_images_ids();
        
        /* start output */
        if ( !empty( $ut_gallery_images ) && is_array( $ut_gallery_images )  ) : 
                
        $script = "<script type='text/javascript'>
        /* <![CDATA[ */
        
		(function($){
			
			'use strict';
	
			$(window).load(function(){
				
				$('#portfolio-gallery-slider-$postID').flexslider({
					
					animation: 'fade',
					controlNav: false,
                    animationLoop: true,
                   	slideshow: false,
					smoothHeight: true,
					startAt: 0
										
				});
				
			});
		
		})(jQuery);
        
        /* ]]> */
        </script>";
        
		$slider ='<div class="ut-portfolio-gallery-slider flexslider" id="portfolio-gallery-slider-' . $postID . '">';
			$slider .='<ul class="slides">';
				
				foreach ( $ut_gallery_images as $ID => $imagedata ) : 
			
					if( isset( $imagedata->guid ) && !empty($imagedata->guid) ) {
								
						$image = $imagedata->guid; // fallback to older wp versions
						
					} else {
						
						$image = wp_get_attachment_image_src($imagedata , 'single-post-thumbnail');
						$image = $image[0];
						
					}
			
					if( !empty($image[0]) ) : 
						
						$slider .='<li>';
							
							$slider .='<img class="' . $image_style . '" alt="' . get_the_title( $postID ) . '" src="' . $image . '" />';
						
						$slider .='</li>';
						
					endif;
									
			  endforeach;
	
			$slider .='</ul>';
		$slider .='</div>';
        
		if( $singular ) {
			$slider = ut_compress_java($script) . $slider;
		}
		
		return $slider;
		
        endif;
		
		
    }
}

/*
|--------------------------------------------------------------------------
| Popup Gallery
|--------------------------------------------------------------------------
*/
if( !function_exists('ut_portfolio_popup_gallery') ) {

    function ut_portfolio_popup_gallery( $postID , $token ) {
                                                        
        /* get all necessary image ID's */
        $ut_gallery_images = ut_portfolio_extract_gallery_images_ids();
        
        /* start output */
        if ( !empty( $ut_gallery_images ) && is_array( $ut_gallery_images )  ) : 
        
		/* needed vars */
		$api_images = NULL;
		$api_titles = NULL;
		$api_descriptions = NULL;
		
		/* javascript */
		$script = '
		
		api_images_'.$postID.' = [];
		api_titles_'.$postID.' = [];
		api_descriptions_'.$postID.' = []
		$.prettyPhoto.open(api_images,api_titles,api_descriptions);
		
		';
		
		$counter = 1;				
		foreach ( $ut_gallery_images as $ID => $imagedata ) : 
				
				if( isset( $imagedata->guid ) && !empty($imagedata->guid) ) {
							
					$image = $imagedata->guid; // fallback to older wp versions
					
				} else {
					
					$image = wp_get_attachment_image_src($imagedata , 'single-post-thumbnail');
					$image = $image[0];
					
				}
		
				if( !empty($image[0]) ) : 
												
					$api_images .= "'".$image."'";
											
				endif;
								
				$api_titles .= "'".get_the_title( $imagedata )."'";
				$api_descriptions .= "'".get_post($imagedata)->post_excerpt."'";				
				
				if($counter != count($ut_gallery_images) ) { $api_images .= ','; $api_titles .= ','; $api_descriptions .= ','; }
				
		$counter++;
		endforeach;
		
		
		$script = "<script type='text/javascript'>
        /* <![CDATA[ */
        
		(function($){
			
			'use strict';
			
			$(document).ready(function(){
				
				var api_images_".$postID." = [ ".$api_images." ],
					api_titles_".$postID." = [ ".$api_titles." ],
					api_descriptions_".$postID." = [ ".$api_descriptions." ]
				
				
				$('.ut-portfolio-popup-".$postID."').click(function(event){
					
					$.prettyPhoto.open(api_images_".$postID.",api_titles_".$postID.",api_descriptions_".$postID.");
						
					event.preventDefault();
			
				});
								
			});
					
		})(jQuery);
        
        /* ]]> */
        </script>";				
		
		return $script;
		
        endif;
		
		
    }
}


/*
|--------------------------------------------------------------------------
| Helper Function : Extract Attachment ID's from gallery shortcode
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_portfolio_extract_gallery_images_ids' ) ) {
    
    function ut_portfolio_extract_gallery_images_ids() {
        
        global $post;
        
        $content = get_the_content();
        $pattern = get_shortcode_regex();
        
        preg_match( "/$pattern/s", $content, $match );
        
        if( isset( $match[2] ) && ( "gallery" == $match[2] ) ) {
            
            $atts = $match[3];
            $atts = shortcode_parse_atts( $match[3] );
            $ut_gallery_images = isset( $atts['ids'] ) ? explode( ',', $atts['ids'] ) : get_children( 'post_type=attachment&post_mime_type=image&post_parent=' . $post->ID .'&order=ASC&orderby=menu_order ID' );
            
            return $ut_gallery_images;
            
        }         
    
    }

}


/*
|--------------------------------------------------------------------------
| Hex to RGB Changer
|--------------------------------------------------------------------------
*/
if( !function_exists('ut_hex_to_rgb') ) :

	function ut_hex_to_rgb($hex) {
				
		$hex = preg_replace("/#/", "", $hex);
		$color = array();
	 
		if(strlen($hex) == 3) {
			$color['r'] = hexdec(substr($hex, 0, 1) . $r);
			$color['g'] = hexdec(substr($hex, 1, 1) . $g);
			$color['b'] = hexdec(substr($hex, 2, 1) . $b);
		}
		else if(strlen($hex) == 6) {
			$color['r'] = hexdec(substr($hex, 0, 2));
			$color['g'] = hexdec(substr($hex, 2, 2));
			$color['b'] = hexdec(substr($hex, 4, 2));
		}
		
		$color = implode(',', $color);
		
		return $color;
	}

endif;


/*
|--------------------------------------------------------------------------
| Custom JS Minifier
|--------------------------------------------------------------------------
*/

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

class ut_portfolio_shortcode {
	
	static $add_showcase_script;
	static $add_masonry_script;
    static $add_gallery_script;
	static $token;
	
	/* init */
	static function init() {
		
		add_shortcode( 'ut_showcase' , array(__CLASS__, 'handle_shortcode') );		
		
	}
	
	/* start shortcode */
	static function handle_shortcode( $atts ) {
		
		extract( shortcode_atts( array( "id" => '' ) , $atts) );
		
		/* no id has been set , nothing more to do here */
		if( empty($id) ) return;
		
		/* set token */
		self::$token = $id;
		
        /* get portfolio type */
		$ut_portfolio_type = get_post_meta( self::$token , 'ut_portfolio_type' , true );
		
        
        /*
        |--------------------------------------------------------------------------
        | Showcase Gallery
        |--------------------------------------------------------------------------
        */
		if( $ut_portfolio_type == 'ut_showcase' ) {
			
			self::$add_showcase_script = true;
			add_action( 'wp_footer' , array(__CLASS__, 'enqueue_showcase_scripts') );
			
			/* create showcase gallery */
			return self::create_showcase_gallery();
            
		}
        
        /*
        |--------------------------------------------------------------------------
        | Portfolio Carousel
        |--------------------------------------------------------------------------
        */
		if( $ut_portfolio_type == 'ut_carousel' ) {
			
			self::$add_showcase_script = true;
			add_action( 'wp_footer' , array(__CLASS__, 'enqueue_showcase_scripts') );
			
			/* create showcase gallery */
			return self::create_portfolio_carousel();
            
		}
		
        /*
        |--------------------------------------------------------------------------
        | Grid / Masonry Gallery
        |--------------------------------------------------------------------------
        */
		if( $ut_portfolio_type == 'ut_masonry' ) {
			
			self::$add_masonry_script = true;
			add_action( 'wp_footer' , array(__CLASS__, 'enqueue_masonry_scripts') );
			
			/* create masonry gallery */
			return self::create_masonry_gallery();
            
		}
        
        /*
        |--------------------------------------------------------------------------
        | Portfolio Filterable Gallery
        |--------------------------------------------------------------------------
        */
        if( $ut_portfolio_type == 'ut_gallery' ) {
			
			self::$add_gallery_script = true;
			add_action( 'wp_footer' , array(__CLASS__, 'enqueue_gallery_scripts') );
			
			/* create masonry gallery */
			return self::create_portfolio_gallery();
            
		}
				

	}
	
	/*
    |--------------------------------------------------------------------------
    | Create hidden slide / popup gallery for all gallery types
    |--------------------------------------------------------------------------
    */
	static function create_hidden_popup_portfolio( $portfolio_args = array() , $image_style = "" ) {
		
		/* no query args - we leave here */
		if(empty($portfolio_args)) {
			return;
		}
		
		/* create hidden portfolio */		
		$hidden_portfolio = '<div id="ut-portfolio-details-wrap-' . self::$token . '" class="ut-portfolio-details-wrap clearfix">';
			
			$hidden_portfolio .= '<div id="ut-portfolio-details-' . self::$token . '" class="inner ut-portfolio-details">';
			
			$hidden_portfolio .= '<div class="ut-portfolio-details-navigation">';
				$hidden_portfolio .= '<a class="prev-portfolio-details" data-wrap="' . self::$token . '" href="#"></a>';
				$hidden_portfolio .= '<a class="close-portfolio-details" data-wrap="' . self::$token . '" href="#"></a>';
				$hidden_portfolio .= '<a class="next-portfolio-details" data-wrap="' . self::$token . '" href="#"></a>';
			$hidden_portfolio .= '</div>';
			
			/* start query */
			$portfolio_query = new WP_Query( $portfolio_args );	
			
			/* loop trough portfolio items */
			if ($portfolio_query->have_posts()) : while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
				
				global $more; 
				
				/* needed variables */
				$more = 0;				
				$portfolio_details = '';
				$post_format = get_post_format();
				
				/* meta data*/
				$ut_portfolio_details = get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_details', true );
				
				/* grab up the featured image url */
				$fullsize = $thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $portfolio_query->post->ID ) );
				
				/* create hidden content div first */
				$hidden_portfolio .= '<div id="ut-portfolio-detail-' . $portfolio_query->post->ID . '" class="ut-portfolio-detail clearfix" data-post="' . $portfolio_query->post->ID . '" data-format="' . $post_format . '">';
					
					/* portfolio details */
					if( is_array( $ut_portfolio_details ) ) {
						
						$portfolio_details .= '<ul class="ut-portfolio-list clearfix">';
						
							foreach( $ut_portfolio_details as $key => $detail ) {
								
								$portfolio_details .= '<li><strong>' . $detail['title'] . ': </strong>' . $detail['value'] . '</li>';
								
							}
						
						$portfolio_details .= '</ul>';
						
					}
					
					/* start markup */
					$hidden_portfolio .= '<div class="grid-80 prefix-10 mobile-grid-100 tablet-grid-80 tablet-prefix-10 ut-portfolio-media">';
						
						if( ! post_password_required() ) {
							
							/* standard post format */
							if( empty( $post_format ) ) {
								
								/* featured image */
								$hidden_portfolio .= '<img class="ut-portfolio-image ' . $image_style . '" alt="' . get_the_title() . '" src="' . $fullsize . '">';
								
								/* get the content */
								$the_content = apply_filters( 'the_content' , get_the_content( '<span class="more-link">' . __( 'Read more', 'ut_portfolio_lang' ) . '<i class="fa fa-chevron-circle-right"></i></span>' ) );

							}
							
							if( $post_format == 'video' ) {
								
								/* get the content */
								$content = get_the_content( '<span class="more-link">' . __( 'Read more', 'ut_portfolio_lang' ) . '<i class="fa fa-chevron-circle-right"></i></span>' );
								
								/* try to catch video url */
								$video_url = get_portfolio_format_video_content( $content );
								
								/* add video to hidden portfolio detail*/
								$hidden_portfolio .= apply_filters( 'the_content' , $video_url );
								
								/* cut out the video url from content and format it */
								$the_content = str_replace( $video_url , "" , $content);
								$the_content = apply_filters( 'the_content' , $the_content );
								
								
							}
							
							if( $post_format == 'gallery' ) {
							
								$hidden_portfolio .= ut_portfolio_flex_slider( $portfolio_query->post->ID , false , $image_style );
								
								/* cut out the gallery shortcode from the content and format it */
								$content = preg_replace( '/(.?)\[(gallery)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', '$1$6', get_the_content( '<span class="more-link">' . __( 'Read more', 'ut_portfolio_lang' ) . '<i class="fa fa-chevron-circle-right"></i></span>' ) );
								$the_content = apply_filters( 'the_content' , $content );
								
							}
							
							
						} else {
						
							$hidden_portfolio .= '<div class="ut-password-protected">' . __('Password Protected Portfolio' , 'ut_portfolio_lang') . '</div>';
							$the_content = get_the_password_form();
							
						}
					
					$hidden_portfolio .= '</div>';
					
					$hidden_portfolio .= '<div class="grid-70 prefix-15 mobile-grid-100 tablet-grid-70 tablet-prefix-15 entry-content clearfix">';
												
						$hidden_portfolio .= '<h2 class="ut-portfolio-title">' . get_the_title() . '</h2>';
						
						$hidden_portfolio .= $portfolio_details;
						
						$hidden_portfolio .= $the_content;
						
					$hidden_portfolio .= '</div>';					
					
				$hidden_portfolio .= '</div>';
				
			/* end loop */
			endwhile; endif;
			
			/* reset query */
			 wp_reset_postdata();
			
			$hidden_portfolio .= '</div>';
			
		$hidden_portfolio .= '</div>';
		
		$hidden_portfolio .= '<div class="clear"></div>';
		
		return $hidden_portfolio;
		
	}
	
    /*
    |--------------------------------------------------------------------------
    | Showcase Gallery
    |--------------------------------------------------------------------------
    */
	static function create_showcase_gallery() {
		
		global $paged;
				
		/* settings */
		$portfolio_categories = get_post_meta( self::$token , 'ut_portfolio_categories' );
        
		/* global portfolio settings */
        $portfolio_settings = get_post_meta( self::$token , 'ut_portfolio_settings' );
        $portfolio_settings = $portfolio_settings[0];
		
        /* showcase options */
        $showcase_options = get_post_meta( self::$token , 'ut_showcase_options' );
        $showcase_options = $showcase_options[0];
        
		/* fallback if no meta has been set */
		$portfolio_per_page   = !empty($portfolio_settings['posts_per_page']) ? $portfolio_settings['posts_per_page'] : 4 ;
		$portfolio_categories = !empty($portfolio_categories) ? $portfolio_categories : array();
						
        /* portfolio query terms */
		$portfolio_terms = array();
		if( is_array($portfolio_categories[0])  && !empty($portfolio_categories[0]) ) {

			foreach( $portfolio_categories[0] as $key => $value) {                
                array_push($portfolio_terms , $key);
			}
			
		}
		
        /* query args */
        $portfolio_args = array(
            
            'post_type'      => 'portfolio',
            'posts_per_page' => $portfolio_per_page,
            'paged'          => $paged,
            'tax_query'      => array( array(
                    'taxonomy' => 'portfolio-category',
                    'terms'    => $portfolio_terms,
                    'field'    => 'term_id'  
            ) )
            
        
        );
        
        /* start query */
        $portfolio_query = new WP_Query( $portfolio_args );
		        
        /* needed javascript */
		$showcase = self::generate_showcase_script( $showcase_options );		
		
        /* start showcase */
		$showcase .= '<div class="ut-portfolio-wrap ' . $portfolio_settings["optional_class"] . '" data-textcolor="' . $portfolio_settings["text_color"] . '" data-opacity="' . $portfolio_settings["hover_opacity"] . '" data-hovercolor="' . ut_hex_to_rgb($portfolio_settings["hover_color"]) . '">';
		
		$showcase .= '<div id="slider_' . self::$token . '" class="flexslider ut-showcase">';
		$showcase .= '<ul class="slides">';				
		
        /* create thumbnail navigation */
        if( isset($showcase_options['display_thumbnail_navigation'] ) ) {
            $showcase_navigation  = '<div id="carousel_' . self::$token . '" class="flexslider ut-showcase-navigation">';
            $showcase_navigation .= '<ul class="slides">';
        }
        				
					/* loop trough portfolio items */
					if ($portfolio_query->have_posts() ) : while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
												
						if ( has_post_thumbnail() && ! post_password_required() ) {		
            
							$fullsize   = wp_get_attachment_url( get_post_thumbnail_id( $portfolio_query->post->ID ) );
						
							$showcase .= '<li>';
								$showcase .= '<img alt="' . get_the_title() . '" src="' . $fullsize . '" />';
							$showcase .= '</li>';
							
							/* create showcase navigation items */
							if( isset($showcase_options['display_thumbnail_navigation'] ) ) {
								
								$thumbnail = ut_resize( $fullsize , 210 , 140 , true , true , true );
								
									$showcase_navigation .= '<li class="ut-hover">';
										
										$showcase_navigation .= '<a href="#">';
										
										$showcase_navigation .= '<figure>';
											$showcase_navigation .= '<img src="' . $thumbnail . '" />';
										$showcase_navigation .= '</figure>';
										
										$showcase_navigation .= '<div class="ut-hover-layer">';
											
											$showcase_navigation .= '<div class="ut-portfolio-info">';
											$showcase_navigation .= '<h3>' . get_the_title() . '</h3>';
											
											$portfolio_cats = wp_get_object_terms( $portfolio_query->post->ID , 'portfolio-category' );
											$showcase_navigation .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
											
										$showcase_navigation .= '</div>';
										
									$showcase_navigation .= '</div>';
									
									$showcase_navigation .= '</a>';
									
								$showcase_navigation .= '</li>';                           
								
							}
						
						} else {
							
							
										
						}                       
						
					endwhile; endif;
				
				/* reset query */
				 wp_reset_postdata();
	    
        /* end showcase navigation */
        if( isset($showcase_options['display_thumbnail_navigation'] ) ) {
            $showcase_navigation .= '</ul>';
            $showcase_navigation .= '</div>';
        }
        
        /* end showcase */		
		$showcase .= '</ul>';
		$showcase .= '</div>';
		        
        /* return final showcase */
        if( isset($showcase_options['display_thumbnail_navigation'] ) ) {
            return $showcase . $showcase_navigation . '</div>';
        } else {
            return $showcase . '</div>';
        }
        
	}
	
	static function generate_showcase_script( $showcase_options ) {
		
		/* settings */
		$container = self::$token;
		$thumbnail_navigation = '';
		$sync = '';
		
		/* showcase navigation script */
		if( isset( $showcase_options['display_thumbnail_navigation'] ) ) :
			
			$thumbnail_navigation = "
			$('#carousel_$container').flexslider({
            	animation: 'slide',
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                itemWidth: 210,
                itemMargin: 5,
                asNavFor: '#slider_$container'
            });";
			
			// sync for slider function
			$sync = "sync: '#carousel_$container'";

		endif;
		/* end showcase navigation */ 
        
                
        /* showcase options */
        $animation      = !empty($showcase_options['animation']) ? $showcase_options['animation'] : 'slide';
        $slideshowSpeed = !empty($showcase_options['slideshowSpeed']) ? $showcase_options['slideshowSpeed'] : '7000'; 
        $animationSpeed = !empty($showcase_options['animationSpeed']) ? $showcase_options['animationSpeed'] : '600'; 
        $directionNav   = !empty($showcase_options['directionNav']) ? 'true' : 'false';
        $smoothHeight   = !empty($showcase_options['smoothHeight']) ? 'true' : 'false';
        
        /* main showcase script */
        $script = "
		<script type='text/javascript'>
		/* <![CDATA[ */ 
        
			(function($){
			
				$(window).load(function(){
				
					$thumbnail_navigation
				
					$('#slider_$container').flexslider({
						
						animation: '$animation',
                    	controlNav: false,
                    	animationLoop: false,
                    	slideshow: true,
                        slideshowSpeed: $slideshowSpeed,
						animationSpeed: $animationSpeed,
                        directionNav: $directionNav,
                        smoothHeight: $smoothHeight,
                        
                        $sync
						
					});
					
				});
			
			})(jQuery);
		
		/* ]]> */ 
		</script>";
		/* end main showcase script */       
               
		
        /* output javascript */
		return ut_compress_java($script);
		
	}
	
    /*
    |--------------------------------------------------------------------------
    | Portfolio Carousel
    |--------------------------------------------------------------------------
    */
    static function create_portfolio_carousel() { 
        				
		/* settings */
		$portfolio_categories = get_post_meta( self::$token , 'ut_portfolio_categories' );
        
		/* global portfolio settings */
        $portfolio_settings = get_post_meta( self::$token , 'ut_portfolio_settings' );
        $portfolio_settings = $portfolio_settings[0];
		
		/* showcase options */
        $carousel_options = get_post_meta( self::$token , 'ut_carousel_options' );
        $carousel_options = $carousel_options[0];
        
		/* detail style */
		$detailstyle = !empty($portfolio_settings['detail_style']) ? $portfolio_settings['detail_style'] : 'slideup';
		        
		/* fallback if no meta has been set */
		$portfolio_per_page   = !empty($portfolio_settings['posts_per_page']) ? $portfolio_settings['posts_per_page'] : 4 ;		
		$portfolio_categories = !empty($portfolio_categories) ? $portfolio_categories : array();
						
        /* portfolio query terms */
		$portfolio_terms = array();
		if( is_array($portfolio_categories[0])  && !empty($portfolio_categories[0]) ) {

			foreach( $portfolio_categories[0] as $key => $value) {                
                array_push($portfolio_terms , $key);
			}
			
		}
		        
		/* query args */
        $portfolio_args = array(
            
            'post_type'      => 'portfolio',
            'posts_per_page' => $portfolio_per_page,
            'tax_query'      => array( array(
                    'taxonomy' => 'portfolio-category',
                    'terms'    => $portfolio_terms,
                    'field'    => 'term_id'  
            ) )
            
        
        );
        
        /* start query */
        $portfolio_query = new WP_Query( $portfolio_args );
		        
        /* needed javascript */
		$carousel = self::generate_carousel_script( $carousel_options );        	
		
		/* gallery style */
		$gallery_style = !empty($carousel_options['style']) ? $carousel_options['style'] : 'style_one';
		$gallery_style_class = NULL;
		
		switch ( $gallery_style ) {
			
			case 'style_one':
				$gallery_style_class = 'portfolio-style-one';
			break;
				
			case 'style_two':
				$gallery_style_class = 'portfolio-style-two';
			break;

		}
		
		/* create hidden gallery */
		if( $detailstyle == 'slideup' ) {
			$carousel .= self::create_hidden_popup_portfolio( $portfolio_args , $portfolio_settings['image_style'] );
		}
		
        /* create carousel */
        $carousel .= '<div id="carousel_' . self::$token . '" class="ut-portfolio-wrap flexslider ut-carousel '.$gallery_style_class.'" data-textcolor="' . $portfolio_settings["text_color"] . '" data-opacity="' . $portfolio_settings["hover_opacity"] . '" data-hovercolor="' . ut_hex_to_rgb($portfolio_settings["hover_color"]) . '">';
        $carousel .= '<ul class="slides">';
        				
            /* loop trough portfolio items */
            if ($portfolio_query->have_posts()) : while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                                
                if ( has_post_thumbnail() && ! post_password_required() ) {		
    
                    $fullsize = $thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $portfolio_query->post->ID ) );
                    $caption = get_post( get_post_thumbnail_id( $portfolio_query->post->ID ) )->post_excerpt;
					
                    /* check if image cropping is active */
                    if( !empty( $carousel_options['image_cropping'] ) ) {
                        
                        /* cropping dimensions */
                        $width  = !empty($carousel_options['crop_size_x']) ? $carousel_options['crop_size_x'] : '542';
                        $height = !empty($carousel_options['crop_size_y']) ? $carousel_options['crop_size_y'] : '542';
                        
                        $thumbnail  =  ut_resize( $fullsize , $width , $height , true , true , true );
                        
                    }
                    
					if( $gallery_style == 'style_one' ) {    
						
						$carousel  .= '<li class="ut-carousel-item ut-hover">';
							
							$title= str_ireplace('"', '', trim(get_the_title()));
							
								/* link markup for detail slideup */
								if( $detailstyle == 'slideup' ) {
									$carousel  .= '<a class="ut-portfolio-link ' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#">';
								}
								
								/* link markup for image popup */
								if( $detailstyle == 'popup' ) {
									
									$popuplink = NULL;
									$post_format = get_post_format();
									
									/* image post or audio post */
									if( empty( $post_format ) || $post_format == 'audio' ) {
										$carousel  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'. $fullsize .'">';
									}
									
									/* video post */
									if( $post_format == 'video' ) {
										
										/* get the content */
										$content = get_the_content( '<span class="more-link">' . __( 'Read more', 'ut_portfolio_lang' ) . '<i class="fa fa-chevron-circle-right"></i></span>' );
										
										/* try to catch video url */
										$popuplink = get_portfolio_format_video_content( $content );
										$carousel  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'.$popuplink.'">';
										
									}
									
									/* gallery post */
									if( $post_format == 'gallery' ) {
										
										$carousel .= ut_portfolio_popup_gallery( $portfolio_query->post->ID , self::$token );
										$carousel .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' '. $portfolio_settings['image_style'] . '" title="' . $title . '" href="'.$fullsize.'">';									
									
									}								
									
								}
								
								$carousel .= '<figure>';
									$carousel .= '<img alt="' . get_the_title() . '" src="' . $thumbnail . '" />';
								$carousel .= '</figure>';
								
								$carousel .= '<div class="ut-hover-layer">';
									$carousel .= '<div class="ut-portfolio-info">';
										
										/* Portfolio Slogan */										
										$carousel .= '<h2 class="portfolio-title">' . get_the_title() . '</h2>';
										
										$portfolio_cats = wp_get_object_terms( $portfolio_query->post->ID , 'portfolio-category' );
										$carousel .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
										
									$carousel .= '</div>';
								$carousel  .= '</div>';
								
							$carousel  .= '</a>';						
							
						$carousel  .= '</li>';
					
					}
					
					if( $gallery_style == 'style_two' ) {    
						
						$carousel  .= '<li class="ut-carousel-item ut-hover">';
							
							$title= str_ireplace('"', '', trim(get_the_title()));
							
								/* link markup for detail slideup */
								if( $detailstyle == 'slideup' ) {
									$carousel  .= '<a class="ut-portfolio-link ' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#">';
								}
								
								/* link markup for image popup */
								if( $detailstyle == 'popup' ) {
									
									$popuplink = NULL;
									$post_format = get_post_format();
									
									/* image post or audio post */
									if( empty( $post_format ) || $post_format == 'audio' ) {
										$carousel  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'. $fullsize .'">';
									}
									
									/* video post */
									if( $post_format == 'video' ) {
										
										/* get the content */
										$content = get_the_content( '<span class="more-link">' . __( 'Read more', 'ut_portfolio_lang' ) . '<i class="fa fa-chevron-circle-right"></i></span>' );
										
										/* try to catch video url */
										$popuplink = get_portfolio_format_video_content( $content );
										$carousel  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'.$popuplink.'">';
										
									}
									
									/* gallery post */
									if( $post_format == 'gallery' ) {
										
										$carousel .= ut_portfolio_popup_gallery( $portfolio_query->post->ID , self::$token );
										$carousel .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' '. $portfolio_settings['image_style'] . '" title="' . $title . '" href="'.$fullsize.'">';									
									
									}								
									
								}
								
								$carousel .= '<figure>';
									$carousel .= '<img alt="' . get_the_title() . '" src="' . $thumbnail . '" />';
								$carousel .= '</figure>';
								
								$carousel .= '<div class="ut-hover-layer">';
									$carousel .= '<div class="ut-portfolio-info">';
										
										if( $post_format == 'video' ) {
											$carousel .= '<i class="fa fa-film fa-lg"></i>';
										}
										
										if( $post_format == 'audio' ) {
											$carousel .= '<i class="fa fa-headphones fa-lg"></i>';
										}
	
										if(  $post_format == 'gallery' ) {
											$carousel .= '<i class="fa fa-camera-retro fa-lg"></i>';
										}
										
										if( empty($post_format) ) {
											$carousel .= '<i class="fa fa-picture-o fa-lg"></i>';
										}
										
										/* Portfolio Slogan */
										$portfolio_cats = wp_get_object_terms( $portfolio_query->post->ID , 'portfolio-category' );
										$carousel .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
										
									$carousel .= '</div>';
								$carousel  .= '</div>';
								
							$carousel  .= '</a>';
							
							$carousel .= '<figcaption>';
								
									/* link markup for detail slideup */
									if( $detailstyle == 'slideup' ) {
										$carousel  .= '<a class="ut-portfolio-link ' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#">';
									}
									
									/* link markup for image popup */
									if( $detailstyle == 'popup' ) {
										
										$popuplink = NULL;
										$post_format = get_post_format();
										
										/* image post or audio post */
										if( empty( $post_format ) || $post_format == 'audio' ) {
											$carousel  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'. $fullsize .'">';
										}
										
										/* video post */
										if( $post_format == 'video' ) {
											
											/* get the content */
											$content = get_the_content( '<span class="more-link">' . __( 'Read more', 'ut_portfolio_lang' ) . '<i class="fa fa-chevron-circle-right"></i></span>' );
											
											/* try to catch video url */
											$popuplink = get_portfolio_format_video_content( $content );
											$carousel  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'.$popuplink.'">';
											
										}
										
										/* gallery post */
										if( $post_format == 'gallery' ) {
											
											$carousel .= ut_portfolio_popup_gallery( $portfolio_query->post->ID , self::$token );
											$carousel .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' '. $portfolio_settings['image_style'] . '" title="' . $title . '" href="'.$fullsize.'">';									
										
										}								
										
									}
								
									$carousel .= '<h2 class="portfolio-title">' . $title . '</h2>';
								
								$carousel  .= '</a>';
								
							$carousel .= '<figcaption>';
							
						$carousel  .= '</li>';
					
					}
					
                }                     
                
            endwhile; endif;
				
        /* reset query */
        wp_reset_postdata();
	    
        /* end showcase navigation */
        $carousel .= '</ul>';
        $carousel .= '</div>';
                
        /* return final carousel */
        return $carousel;

    
    }
    
    static function generate_carousel_script( $carousel_options ) {
		
		/* settings */
		$container = self::$token;
        $columns   = !empty($carousel_options['columns']) ? $carousel_options['columns'] : 4;
        
        /* script */
        $script = "
		<script type='text/javascript'>
		/* <![CDATA[ */ 
        
			(function($){
			
				$(window).load(function(){
				    
                    var \$container = $('#carousel_$container');
                    
					if( $(window).width() <= 767) {
						columns = 2;
					} else {
						columns = $columns;
					}
					                    
                    function getGridSize() {
                        return \$container.width() / columns
                    }
                    					                                                                
					$('#carousel_$container').flexslider({
                        animation: 'slide',
                        controlNav: false,
                        animationLoop: false,
                        slideshow: false,
                        itemWidth: getGridSize(),
                        itemMargin: 0,
						touch: true
                    });
					
				});
				
				$(window).smartresize(function(){
					
					$('#carousel_$container').flexslider(0);
											
				});
				
			})(jQuery);
		
		/* ]]> */ 
		</script>";
		/* end carousel script */ 
		
        /* return javascript */
		return ut_compress_java($script);
		
	}
    
    
    /*
    |--------------------------------------------------------------------------
    | Grid / Masonry Gallery
    |--------------------------------------------------------------------------
    */
	static function create_masonry_gallery() {
		
		global $paged;
		
		/* settings */
		$portfolio_categories = get_post_meta( self::$token , 'ut_portfolio_categories' );
		
		/* global portfolio settings */
        $portfolio_settings = get_post_meta( self::$token , 'ut_portfolio_settings' );
        $portfolio_settings = $portfolio_settings[0];
		
		/* detail style */
		$detailstyle = !empty($portfolio_settings['detail_style']) ? $portfolio_settings['detail_style'] : 'slideup';
		
        /* masonry options */
        $masonry_options = get_post_meta( self::$token , 'ut_masonry_options' );
        $masonry_options = $masonry_options[0];
        
		/* fallback if no meta has been set */
		$portfolio_per_page   = !empty($portfolio_settings['posts_per_page']) ? $portfolio_settings['posts_per_page'] : 4 ;
		$portfolio_categories = !empty($portfolio_categories) ? $portfolio_categories : array();
				
		/* portfolio query terms */
		$portfolio_terms = array();
		if( is_array($portfolio_categories[0])  && !empty($portfolio_categories[0]) ) {

			foreach( $portfolio_categories[0] as $key => $value) {                
                array_push($portfolio_terms , $key);
			}
			
		}
		
        /* query args */
        $portfolio_args = array(
            
            'post_type'      => 'portfolio',
            'posts_per_page' => $portfolio_per_page,
            'paged'          => $paged,
            'tax_query'      => array( array(
                    'taxonomy' => 'portfolio-category',
                    'terms'    => $portfolio_terms,
                    'field'    => 'term_id'  
            ) )
            
        
        );
        
        /* start query */
        $portfolio_query = new WP_Query( $portfolio_args );		
		
		/* needed javascript */
		$masonry  = self::generate_masonry_script( $masonry_options );
        
		/* create hidden gallery */
		if( $detailstyle == 'slideup' ) {
			$masonry .= self::create_hidden_popup_portfolio( $portfolio_args , $portfolio_settings['image_style'] );
		}
		
        /* portfolio wrapper */		
		$masonry .= '<div id="ut_masonry_' . self::$token . '" class="ut-portfolio-wrap" data-textcolor="' . $portfolio_settings["text_color"] .'" data-opacity="' . $portfolio_settings["hover_opacity"] . '" data-hovercolor="' . ut_hex_to_rgb($portfolio_settings["hover_color"]) . '">';
			
			/* loop trough portfolio items */
			if ($portfolio_query->have_posts()) : while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
				
				$fullsize = $thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $portfolio_query->post->ID ) );
				$caption = get_post( get_post_thumbnail_id( $portfolio_query->post->ID ) )->post_excerpt;
					
				/* check if image cropping is active */
				if( !empty( $masonry_options['image_cropping'] ) ) {
					
					/* cropping dimensions */
					$width  = !empty($masonry_options['crop_size_x']) ? $masonry_options['crop_size_x'] : '542';
					$height = !empty($masonry_options['crop_size_y']) ? $masonry_options['crop_size_y'] : '542';
					
					$thumbnail  =  ut_resize( $fullsize , $width , $height , true , true , true );
					
				}
							
					
				/* create single content item */				
				$masonry .= '<div class="ut-masonry ut-hover">';
					
						$title= str_ireplace('"', '', trim(get_the_title()));
						
						/* link markup for detail slideup */
						if( $detailstyle == 'slideup' ) {
							$masonry .= '<a class="ut-portfolio-link ' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#">';
						}
						
						/* link markup for image popup */
						if( $detailstyle == 'popup' ) {
							
							$popuplink = NULL;
							$post_format = get_post_format();
							
							/* image post or audio post */
							if( empty( $post_format ) || $post_format == 'audio' ) {
								$masonry  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'. $fullsize .'">';
							}
							
							/* video post */
							if( $post_format == 'video' ) {
								
								/* get the content */
								$content = get_the_content( '<span class="more-link">' . __( 'Read more', 'ut_portfolio_lang' ) . '<i class="fa fa-chevron-circle-right"></i></span>' );
								
								/* try to catch video url */
								$popuplink = get_portfolio_format_video_content( $content );
								$masonry  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'.$popuplink.'">';
								
							}
							
							/* gallery post */
							if( $post_format == 'gallery' ) {
								
								$masonry .= ut_portfolio_popup_gallery( $portfolio_query->post->ID , self::$token );
								$masonry .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' '. $portfolio_settings['image_style'] . '" title="' . $title . '" href="'.$fullsize.'">';									
							
							}								
							
						}
					
						if ( has_post_thumbnail() && ! post_password_required() ) :		
							
							$masonry .= '<figure>';
								$masonry .= '<img alt="' . get_the_title() . '" src="' . $thumbnail . '" />';
							$masonry .= '</figure>';
							
						else :
							
							$masonry .= '<div class="ut-password-protected">' . __('Password Protected Portfolio' , 'ut_portfolio_lang') . '</div>';
										
						endif;
						
						$masonry .= '<div class="ut-hover-layer">';
							$masonry .= '<div class="ut-portfolio-info">';
								
								/* Portfolio Title and Categories */
								$masonry .= '<h2 class="portfolio-title">' . get_the_title() . '</h2>';								
								
								/* get all portfolio-categories for this item */
								$portfolio_cats = wp_get_object_terms( $portfolio_query->post->ID , 'portfolio-category' );
								$masonry .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
								
								
							$masonry .= '</div>';
						$masonry .= '</div>';
				
					$masonry .= '</a>';				
				$masonry .= '</div>';
				
			endwhile; endif;
		
		$masonry .= '</div><!-- end ut_masonry_' . self::$token . '-->';
				
		/* reset query */
		wp_reset_postdata();
		
		return  $masonry;
		
	}
	
	static function generate_masonry_script( $masonry_options ) {
		
        /* settings */
		$container = self::$token;
		$columns = !empty($masonry_options['columns']) ? $masonry_options['columns'] : 5;
        $height = !empty($masonry_options['crop_size_y']) ? $masonry_options['crop_size_y'] : '350';
		
		$script = "
		
		<script type='text/javascript'>
		
		/* <![CDATA[ */ 
        
        	(function($){ 
				
				$(document).ready(function() {
				
					$('#ut_masonry_$container').utmasonry({ columns : $columns , itemClass : 'ut-grid-item' , unitHeight : $height });

				}); 
			
			})(jQuery);    
        
        /* ]]> */ 
		
		</script>";
		
		return ut_compress_java($script);
		
	}
	
    /*
    |--------------------------------------------------------------------------
    | Portfolio Filterable Gallery
    |--------------------------------------------------------------------------
    */
    static function create_portfolio_gallery() {
		
		global $paged , $wp_query;
        
        /* pagination */		
        if  ( empty($paged) ) {
                if ( !empty( $_GET['paged'] ) ) {
                        $paged = $_GET['paged'];
                } elseif ( !empty($wp->matched_query) && $args = wp_parse_args($wp->matched_query) ) {
                        if ( !empty( $args['paged'] ) ) {
                                $paged = $args['paged'];
                        }
                }
                if ( !empty($paged) )
                        $wp_query->set('paged', $paged);
        }   
        
		$temp = $wp_query;
        $wp_query = $term = null;
		
		/* settings */
		$portfolio_categories = get_post_meta( self::$token , 'ut_portfolio_categories' );
		$term = '';
		
		/* global portfolio settings */
        $portfolio_settings = get_post_meta( self::$token , 'ut_portfolio_settings' );
        $portfolio_settings = $portfolio_settings[0];
				
        /* gallery options */
        $gallery_options = get_post_meta( self::$token , 'ut_gallery_options' );
        $gallery_options = $gallery_options[0];
        
		/* detail style */
		$detailstyle = !empty($portfolio_settings['detail_style']) ? $portfolio_settings['detail_style'] : 'slideup';
		
		/* columnset */
		$columnset = !empty($gallery_options['columns']) ? $gallery_options['columns'] : 4;
		$gutter = !empty($gallery_options['gutter']) ? 'gutter' : '';
		
		/* image style */
		$image_style_class = $portfolio_settings['image_style'];
		
		/* variables for last row item */
		switch ($columnset) {
			case 2:
				$z = 0;
				$counter = 1;
				break;
			case 3:
				$z = 4;
				$counter = 2;
				break;
			case 4:
				$z = 5;
				$counter = 3;
				break;
		}
		
		/* fallback if no meta has been set */
		$portfolio_per_page   = !empty($portfolio_settings['posts_per_page']) ? $portfolio_settings['posts_per_page'] : 4 ;
		$portfolio_categories = !empty($portfolio_categories) ? $portfolio_categories : array();
		
		/* portfolio query terms */
		$portfolio_terms = array();
		if( is_array($portfolio_categories[0])  && !empty($portfolio_categories[0]) ) {

			foreach( $portfolio_categories[0] as $key => $value) {                
                array_push($portfolio_terms , $key);
			}
			
			$portfolio_terms_query = $portfolio_terms;
			
		}
		
		if( $gallery_options['filter_type'] == 'static' && !empty($_GET['termID']) ) {
			
			/* sanitize term */
			$term = absint( $_GET['termID'] );
			
			/* reset terms */
			$portfolio_terms_query = array();
			array_push($portfolio_terms_query , $term);			
		
		}
				
        /* query args */
        $portfolio_args = array(
            
            'post_type'      => 'portfolio',
            'posts_per_page' => $portfolio_per_page,
            'paged'          => $paged,
            'tax_query'      => array( array(
                    'taxonomy' => 'portfolio-category',
                    'terms'    => $portfolio_terms_query,
                    'field'    => 'term_id'  
            ) )
            
        
        );
        
        /* start query */
        $portfolio_query = $wp_query = new WP_Query( $portfolio_args );
        
        /* portfolio filter */                
        if( !empty($gallery_options['filter']) ) :
        		
        $filter  = '<div class="ut-portfolio-menu-wrap"><ul id="ut-portfolio-menu-' . self::$token . '" class="ut-portfolio-menu '.(!empty($gallery_options['filter_style']) ? $gallery_options['filter_style'] : 'style_one').'">';
            
            /* reset button */
			$reset = !empty($gallery_options['reset_text']) ? $gallery_options['reset_text'] : __('All' , 'ut_portfolio_lang');
			
            if( $gallery_options['filter_type'] == 'static' ) {
				
				$selected = (empty($term)) ? 'class="selected"' : '';
				$filter .= '<li><a href="?term=" data-filter="*" ' . $selected . '>' . $reset . '</a></li>';
			
			} else {
			
				$filter .= '<li><a href="#" data-filter="*" class="selected">' . $reset . '</a></li>';
				
			}
            
            /* get taxonomies */
            $taxonomies = get_terms('portfolio-category');            
            $taxonomiesarray =  json_decode(json_encode($taxonomies), true);
					    
            if( is_array($portfolio_terms) && is_array($taxonomies) ) {
                
                foreach ($portfolio_terms as $single_term ) {
										
                    $key = self::search_tax_key( $single_term , $taxonomiesarray );
										                    
					if( $gallery_options['filter_type'] == 'static' && !empty($key) ) {
						
						$selected = ( $taxonomies[$key]->term_id == $term ) ? 'class="selected"' : '';
						
						$filter .= '<li><a ' . $selected . ' href="?termID=' . $taxonomies[$key]->term_id . '#ut-portfolio-items-' . self::$token . '" data-filter=".'.$taxonomies[$key]->slug.'-filt">'.$taxonomies[$key]->name.'</a></li>';
						
					} else {
						
                        if( isset($taxonomies[$key]->slug) ) {
						    $filter .= '<li><a href="#" data-filter=".'.$taxonomies[$key]->slug.'-filt">'.$taxonomies[$key]->name.'</a></li>';
                        }
                        
					}
					
					
                }
            
			}      
        
        $filter .= '</ul></div>';
        
        endif;
        
        /* needed javascript */
		$gallery = self::generate_gallery_script( $gallery_options , $counter );
        
		/* create hidden gallery */
		if( $detailstyle == 'slideup' ) {
			$gallery .= self::create_hidden_popup_portfolio( $portfolio_args , $portfolio_settings['image_style'] );
		}		
		
        /* output portfolio wrap */
        $gallery .= '<div id="ut-portfolio-wrap" class="ut-portfolio-wrap" data-textcolor="' . $portfolio_settings["text_color"] .'" data-opacity="' . $portfolio_settings["hover_opacity"] . '" data-hovercolor="' . ut_hex_to_rgb($portfolio_settings["hover_color"]) . '">';
		$gallery .= '<a class="ut-portfolio-offset-anchor" style="top:-120px;" id="ut-portfolio-items-' . self::$token . '-anchor"></a>';
		
        /* add filter */
        if( isset($gallery_options['filter']) ) {
            $gallery .= $filter;
        }
        
        /* output portfolio container */
        $gallery .= '<div id="ut-portfolio-items-' . self::$token . '" class="ut-portfolio-item-container">';
        	
            /* loop trough portfolio items */
			if ($portfolio_query->have_posts()) : while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                				
                /* needed variables */
                $projecttype = '';
                $title = str_ireplace('"', '', trim(get_the_title()));
                $post_format = get_post_format();
				
				/* itemposition */
				$itemposition = '';
				if($columnset !=3) { 
					if($columnset == 2) { (($z%2)==0) ? $itemposition = '' : $itemposition = 'last'; }
					if($columnset == 4) { (($z%4)==0) ? $itemposition = 'last' : $itemposition = ''; }
				} else { 
					if(($z%3) == 0) { $itemposition = 'last'; $z = 3; } 
				} 
				
                /* get all portfolio-categories for this item ( needed for filter ) */
                $portfolio_cats = wp_get_object_terms( $portfolio_query->post->ID , 'portfolio-category' );
                
                /* set filter attributes */               
                if( is_array($portfolio_cats) ) {
                    foreach($portfolio_cats as $single_cat) {
                        $projecttype .=  $single_cat->slug."-filt ";
                    }
                }
                
				/* gallery style */
				$gallery_style = !empty($gallery_options['style']) ? $gallery_options['style'] : 'style_one';
				
				/* portfolio featured image */
				$fullsize = $thumbnail = wp_get_attachment_url( get_post_thumbnail_id($portfolio_query->post->ID) );
				$caption = get_post( get_post_thumbnail_id( $portfolio_query->post->ID ) )->post_excerpt;
				
				/* check if image cropping is active */
				if( !empty( $gallery_options['image_cropping'] ) ) {
					
					/* cropping dimensions */
					$width  = !empty($gallery_options['crop_size_x']) ? $gallery_options['crop_size_x'] : '542';
					$height = !empty($gallery_options['crop_size_y']) ? $gallery_options['crop_size_y'] : '542';
					
					$thumbnail  =  ut_resize( $fullsize , $width , $height , true , true , true );
					
				}
				
				/* style one images with title */
				if( $gallery_style == 'style_one') {
				
					/* create single portfolio item */
					$gallery .= '<article class="' . $projecttype . ' ' . $itemposition . ' ut-masonry ' . $gutter . ' portfolio-style-one">';
						
						$gallery .= '<div class="ut-portfolio-item ut-hover">';
												
							/* link markup for slideup details */
							if( $detailstyle == 'slideup' ) {							
								$gallery .= '<a class="ut-portfolio-link ' . $image_style_class . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#ut-portfolio-details-wrap-' . self::$token . '">';
							}
							
							/* link markup for image popup */
							if( $detailstyle == 'popup' ) {
								
								$popuplink = NULL;
																
								/* image post or audio post */
								if( empty( $post_format ) || $post_format == 'audio' ) {
									$gallery  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'. $fullsize .'">';
								}
								
								/* video post */
								if( $post_format == 'video' ) {
									
									/* get the content */
									$content = get_the_content( '<span class="more-link">' . __( 'Read more', 'ut_portfolio_lang' ) . '<i class="fa fa-chevron-circle-right"></i></span>' );
									
									/* try to catch video url */
									$popuplink = get_portfolio_format_video_content( $content );
									$gallery  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'.$popuplink.'">';
									
								}
								
								/* gallery post */
								if( $post_format == 'gallery' ) {
									
									$gallery .= ut_portfolio_popup_gallery( $portfolio_query->post->ID , self::$token );
									$gallery .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'.$fullsize.'">';									
								
								}								
								
							}							
							
							if ( has_post_thumbnail() && ! post_password_required() ) :		
						
								$gallery .= '<figure><img alt="' . $title . '" src="' . $thumbnail . '" /></figure>';
																
							elseif( post_password_required() ) :
								
								$gallery .= '<div class="ut-password-protected">' . __('Password Protected Portfolio' , 'ut_portfolio_lang') . '</div>';
							
							endif;
								
								$gallery .= '<div class="ut-hover-layer">';
									$gallery .= '<div class="ut-portfolio-info">';
							
									/* item title */
									$gallery .= '<h2 class="portfolio-title">' . $title . '</h2>';								
									$gallery .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
									
									$gallery .= '</div>';
								$gallery .= '</div>';								
							
							$gallery .= '</a>';
															
						$gallery .= '</div>';
					
					$gallery .= '</article>';		

				}
				
				
				/* style two only images */
				if( $gallery_style == 'style_two') {					
					
					/* create single portfolio item */
					$gallery .= '<article class="' . $projecttype . ' ' . $itemposition . ' ut-masonry ' . $gutter . ' portfolio-style-two">';
						
						$gallery .= '<div class="ut-portfolio-item ut-hover">';
							
							/* link markup for slideup details */
							if( $detailstyle == 'slideup' ) {							
								$gallery .= '<a class="ut-portfolio-link ' . $image_style_class . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#ut-portfolio-details-wrap-' . self::$token . '">';
							}
							
							/* link markup for image popup */
							if( $detailstyle == 'popup' ) {
								
								$popuplink = NULL;
								
								/* image post or audio post */
								if( empty( $post_format ) || $post_format == 'audio' ) {
									$gallery  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'. $fullsize .'">';
								}
								
								/* video post */
								if( $post_format == 'video' ) {
									
									/* get the content */
									$content = get_the_content( '<span class="more-link">' . __( 'Read more', 'ut_portfolio_lang' ) . '<i class="fa fa-chevron-circle-right"></i></span>' );
									
									/* try to catch video url */
									$popuplink = get_portfolio_format_video_content( $content );
									$gallery  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'.$popuplink.'">';
									
								}
								
								/* gallery post */
								if( $post_format == 'gallery' ) {
									
									$gallery .= ut_portfolio_popup_gallery( $portfolio_query->post->ID , self::$token );
									$gallery .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' class="' . $portfolio_settings['image_style'] . '" title="' . $title . '" href="#">';									
								
								}								
								
							}
							
							if ( has_post_thumbnail() && ! post_password_required() ) :		
						
								$gallery .= '<figure><img alt="' . $title . '" src="' . $thumbnail . '" /></figure>';
																
							elseif( post_password_required() ) :
								
								$gallery .= '<div class="ut-password-protected">' . __('Password Protected Portfolio' , 'ut_portfolio_lang') . '</div>';
							
							endif;
							
								$gallery .= '<div class="ut-hover-layer">';
									$gallery .= '<div class="ut-portfolio-info">';
							
									if( $post_format == 'video' ) {
										$gallery .= '<i class="fa fa-film fa-lg"></i>';
									}
									
									if( $post_format == 'audio' ) {
										$gallery .= '<i class="fa fa-headphones fa-lg"></i>';
									}

									if(  $post_format == 'gallery' ) {
										$gallery .= '<i class="fa fa-camera-retro fa-lg"></i>';
									}
									
									if( empty($post_format) ) {
										$gallery .= '<i class="fa fa-picture-o fa-lg"></i>';
									}									
									
									$gallery .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
									
									$gallery .= '</div>';
								$gallery .= '</div>';
							
							$gallery .= '</a>';
								
							$gallery .= '<figcaption>';
																
								/* link markup for slideup details */
								if( $detailstyle == 'slideup' ) {							
									$gallery .= '<a class="ut-portfolio-link ' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#ut-portfolio-details-wrap-' . self::$token . '">';
								}
								
								/* link markup for image popup */
								if( $detailstyle == 'popup' ) {
									
									$popuplink = NULL;
									
									/* image post or audio post */
									if( empty( $post_format ) || $post_format == 'audio' ) {
										$gallery  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'. $fullsize .'">';
									}
									
									/* video post */
									if( $post_format == 'video' ) {
										
										/* get the content */
										$content = get_the_content( '<span class="more-link">' . __( 'Read more', 'ut_portfolio_lang' ) . '<i class="fa fa-chevron-circle-right"></i></span>' );
										
										/* try to catch video url */
										$popuplink = get_portfolio_format_video_content( $content );
										$gallery  .= '<a data-rel="utPortfolio" class="' . $portfolio_settings['image_style'] . '" title="' . $caption . '" href="'.$popuplink.'">';
										
									}
									
									/* gallery post */
									if( $post_format == 'gallery' ) {
										
										$gallery .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' class="' . $portfolio_settings['image_style'] . '" title="' . $title . '" href="#">';										
									
									}								
									
								}	
								
								/* item title */
								$gallery .= '<h2 class="portfolio-title">' . $title . '</h2>';
								$gallery .= '</a>';
								
								
							$gallery .= '</figcaption>';
											
						$gallery .= '</div>';
					
					$gallery .= '</article>';  
				
				}
            
            $z++; endwhile; endif;
            
        /* end portfolio container */
        $gallery .= '</div>';
		
		/* portfolio pagination */
		if( $portfolio_query->max_num_pages > 1 ){
									
			$gallery .= '<nav class="ut-portfolio-pagination clearfix '.(!empty($gallery_options['filter_style']) ? $gallery_options['filter_style'] : 'style_one').'">';
			
			if ( $paged > 1 ) { 
        		$gallery .= '<a href="?paged=' . ($paged -1) .'&amp;termID='.$term.'#ut-portfolio-items-' . self::$token . '-anchor"><i class="fa fa-angle-double-left"></i></a>';
			}
			
			for( $i=1 ;$i<=$portfolio_query->max_num_pages; $i++ ){
				
				$selected = ($paged == $i) ? 'selected' : '';
				$gallery .= '<a href="?paged=' . $i . '&amp;termID='.$term.'#ut-portfolio-items-' . self::$token . '-anchor" class="' . $selected . '">' . $i . '</a>';

            }
			
			if($paged < $portfolio_query->max_num_pages){
                $gallery .= '<a href="?paged=' . ($paged + 1) . '&amp;termID='.$term.'#ut-portfolio-items-' . self::$token . '-anchor"><i class="fa fa-angle-double-right"></i></a>';
            } 
			
			$gallery .= '</nav>';
		
		}

				
        /* end portfolio wrap */
        $gallery .= '</div>';
        
        /* reset query */
		 wp_reset_postdata();
		
		/* restore wp_query */
		$wp_query = null; $wp_query = $temp;
		
        /* return final gallery */
        return $gallery;

    
    }
        
    static function generate_gallery_script( $gallery_options , $counter = 3 ) {
        
		$gutter = !empty($gallery_options['gutter']) ? 'on' : '';
				        
        $script = '
        <script type="text/javascript">
        /* <![CDATA[ */
        (function($) {
			    
            $(document).ready(function($){
 
                "use strict";
                
                var $container = $("#ut-portfolio-items-' . self::$token . '"),
					columns = ' . $gallery_options['columns'] . ',
					gutter = "' . $gutter . '",
					gutterwidth = "",
					$sortedItems = "";
                
				
				function ut_call_isotope( update ) {
					
					if( $(window).width() > 1024) {
						columns = ' . $gallery_options['columns'] . ';
					} 
					
					if( $(window).width() <= 1024) {
						columns = 3;
					} 
					
					if( $(window).width() <= 767) {
						columns = 2;
					} 				
					
					if(gutter === "on") {
						$container.children().width( Math.floor($container.width() / columns - ( 20  * ( columns - 1 ) / columns ))).addClass("show");
						gutterwidth = 20;
					} else {
						$container.children().width( Math.floor($container.width() / columns )).addClass("show");
						gutterwidth = 0;
					}
					
					if(update) {
						$container.children().removeClass("first last");
					}
					
					/* IsoTope
					================================================== */                                    
					$container.isotope({
					  
					  	itemSelector : ".ut-masonry",
					  	animationEngine : "best-available",
					  	resizable: false,
					  	layoutMode: "fitRows",
					  	masonry: { columnWidth: $container.width() / columns - gutterwidth },
						itemPositionDataEnabled: true,
						onLayout: function (elems, instance) {
							
							var items, rows, numRows, row, prev, i;
							
							$(".parallax-banner").each(function(index, element) {
								$(this).trigger( "scroll" );									
							});
							
							// gather info for each element
							items = elems.map(function () {
								var el = $(this), pos = el.data("isotope-item-position");
								return {
									x: pos.x,
									y: pos.y,
									w: el.width(),
									h: el.height(),
									el: el
								};
							});
					
							// first pass to find the first and last items of each row
							rows = [];
							i = {};
							items.each(function () {
								var y = this.y, r = i[y];
								if (!r) {
									r = {
										y: y,
										first: null,
										last: null
									};
									rows.push(r);
									i[y] = r;
								}
								if (!r.first || this.x < r.first.x) {
									r.first = this;
								}
								if (!r.last || this.x > r.last.x) {
									r.last = this;
								}
							});
							rows.sort(function (a, b) { return a.y - b.y; });
							numRows = rows.length;
					
							// compare items for each row against the previous row
							for (prev = rows[0], i = 1; i < numRows; prev = row, i++) {
								row = rows[i];
								if (prev.first.x < row.first.x &&
										prev.first.y + prev.first.h > row.y) {
									row.first = prev.first;
								}
								if (prev.last.x + prev.last.w > row.last.x + row.last.w &&
										prev.last.y + prev.last.h > row.y) {
									row.last = prev.last;
								}
							}
					
							// assign classes to first and last elements
							elems.removeClass("first last");
							$.each(rows, function () {
								this.first.el.addClass("first");
								this.last.el.addClass("last");
							});
							
							$container.addClass("animated");
							elems.addClass("animated");
							
						}
						
					}).isotope("reLayout"); 				
				
				}
				
                $container.imagesLoaded( function(){
            		
					/* create isotope */
					ut_call_isotope( false );
										
					$(window).smartresize(function(){
												
						/* update isotope */
						ut_call_isotope( true );
						
						/* trigger click */
						$("#ut-portfolio-menu-' . self::$token . ' a").first().trigger("click");
								
					}); 
					
					var $sortedItems = $container.data("isotope").$filteredAtoms;';
				
				/* additonal call for ajax filter */
				if( $gallery_options['filter_type'] == 'ajax' ) :
				
				$script .= '
				
				/* IsoTope Filtering
                ================================================== */               
                $("#ut-portfolio-menu-' . self::$token . ' a").each(function( index ) {
						
						var searchforclass = $(this).attr("data-filter");
						if( !$(searchforclass).length  ) {
							// hide filter if we do not have any children to filter
							$(this).hide();
						}
						
				});				
				
				$("#ut-portfolio-menu-' . self::$token . ' a").click(function(){
                  
				  	var selector = $(this).attr("data-filter");
                  	$container.isotope({ filter: selector });
                  	
					$container.find(".last").removeClass("last");
					var i = columns - 1;		  
					$.each($sortedItems, function(key, value) {
						if($(this).hasClass("isotope-hidden")) {
							i++;
						}
						if(((key-i)/ columns)==0) {
							$(this).addClass("last");
							i = columns+i;
						}
					});
				  
                  	if ( !$(this).hasClass("selected") ) {
                        $(this).parents("#ut-portfolio-menu-' . self::$token . '").find(".selected").removeClass("selected");
                        $(this).addClass("selected");
                  	}          
                  
                  	$container.isotope("reLayout",function(){
						$.waypoints("refresh");
					});
					
					
                  	return false;
				  
                }); ';
				
				endif;
				       
            $script .= ' });  
        
            });
			
        }(jQuery));
		    
        /* ]]> */
        </script>        
        ';
        
        return ut_compress_java($script);
    
    }
    
    static function search_tax_key( $id, $array ) {
		        
        foreach ($array as $key => $val) {

           if($val['term_id'] == $id) {
               return $key;
           }
           
        }
        
        return null;
            
    }
    	  
	static function enqueue_showcase_scripts() {
		
		if ( ! self::$add_showcase_script )  {
            return;
        }
		
		/* needed js */
		wp_enqueue_script('ut-flexslider-js' , UT_PORTFOLIO_URL . 'assets/js/plugins/flexslider/jquery.flexslider-min.js');
		wp_enqueue_script('ut-effect' , UT_PORTFOLIO_URL . 'assets/js/ut.effects.js');	
		
		/* needed css */
		wp_enqueue_style('ut-flexslider' , UT_PORTFOLIO_URL . 'assets/css/plugins/flexslider/flexslider.css');
		
	}
	
	static function enqueue_masonry_scripts() {
		
		if ( ! self::$add_masonry_script )  {
            return;
        }
		
		/* needed js */
		wp_enqueue_script('ut-perfectmasonry-js' , UT_PORTFOLIO_URL . 'assets/js/jquery.isotope.perfectmasonry.min.js' , array());
		wp_enqueue_script('ut-imagesloaded-js' 	 , UT_PORTFOLIO_URL . 'assets/js/jquery.images.loaded.min.js' , array(), '1.8');
		wp_enqueue_script('ut-masonry-js' 		 , UT_PORTFOLIO_URL . 'assets/js/jquery.utmasonry.js' , array(), '1.8');
		wp_enqueue_script('ut-effect' 			 , UT_PORTFOLIO_URL . 'assets/js/ut.effects.js');		
	
	}
    
    static function enqueue_gallery_scripts() {
		
		if ( ! self::$add_gallery_script )  {
            return;
        }
		
		/* needed js */
		wp_enqueue_script('ut-perfectmasonry-js' , UT_PORTFOLIO_URL . 'assets/js/jquery.isotope.perfectmasonry.min.js' , array());
		wp_enqueue_script('ut-imagesloaded-js' 	 , UT_PORTFOLIO_URL . 'assets/js/jquery.images.loaded.min.js' , array(), '1.8');
		wp_enqueue_script('ut-masonry-js' 		 , UT_PORTFOLIO_URL . 'assets/js/jquery.utmasonry.js' , array(), '1.8');
		wp_enqueue_script('ut-effect' 			 , UT_PORTFOLIO_URL . 'assets/js/ut.effects.js');
			
	}
	
	
}

ut_portfolio_shortcode::init(); ?>