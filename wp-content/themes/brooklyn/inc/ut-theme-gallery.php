<?php

/* remove default gallery shortcode */
remove_shortcode('gallery');

/**
 * The Gallery shortcode.
 * with optional output for a pretty lightbox 
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post or page 
 *
 *
 * @param array $attr Attributes of the shortcode.
 * @return string HTML content to display gallery.
 */

if ( ! function_exists( 'ut_gallery_shortcode' ) ) :
 
	function ut_gallery_shortcode($attr) {
		
		$post = get_post();
	
		static $instance = 0;
		$instance++;
	
		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) )
				$attr['orderby'] = 'post__in';
			$attr['include'] = $attr['ids'];
		}
	
		// Allow plugins/themes to override the default gallery template.
		$output = apply_filters('post_gallery', '', $attr);
		if ( $output != '' )
			return $output;
	
		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] )
				unset( $attr['orderby'] );
		}
	
		extract(shortcode_atts(array(
			'order'      			=> 'ASC',
			'orderby'    			=> 'menu_order ID',
			'id'         			=> $post ? $post->ID : 0,
			'itemtag'    			=> 'dl',
			'icontag'    			=> 'dt',
			'captiontag' 			=> 'dd',
			'columns'    			=> 3,
			'size'       			=> 'thumbnail',
			'include'    	   		=> '',
			'exclude'    	   		=> '',
			'ut_gallery_lightbox' 	=> 'off'
		), $attr, 'gallery'));
	
		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';
	
		if ( !empty($include) ) {
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	
			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( !empty($exclude) ) {
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}
	
		if ( empty($attachments) )
			return '';
	
		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			return $output;
		}
		
		$itemtag = tag_escape($itemtag);
		$captiontag = tag_escape($captiontag);
		$icontag = tag_escape($icontag);
		$valid_tags = wp_kses_allowed_html( 'post' );
		if ( ! isset( $valid_tags[ $itemtag ] ) )
			$itemtag = 'dl';
		if ( ! isset( $valid_tags[ $captiontag ] ) )
			$captiontag = 'dd';
		if ( ! isset( $valid_tags[ $icontag ] ) )
			$icontag = 'dt';
	
		$columns = intval($columns);
		$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
		$float = is_rtl() ? 'right' : 'left';
	
		$selector = "gallery-{$instance}";
	
		$gallery_style = $gallery_div = '';
		if ( apply_filters( 'use_default_gallery_style', true ) )
			$gallery_style = "
			<style type='text/css'>
				#{$selector} {
					margin: auto;
				}
				#{$selector} .gallery-item {
					float: {$float};
					margin-top: 10px;
					text-align: center;
					width: {$itemwidth}%;
				}
				#{$selector} img {
					border: 2px solid #cfcfcf;
				}
				#{$selector} .gallery-caption {
					margin-left: 0;
				}
				/* see gallery_shortcode() in wp-includes/media.php */
			</style>";
		$size_class = sanitize_html_class( $size );
		$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
		$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
	
		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			if ( ! empty( $attr['link'] ) && 'file' === $attr['link'] )
				$image_output = wp_get_attachment_link( $id, $size, false, false );
			elseif ( ! empty( $attr['link'] ) && 'none' === $attr['link'] )
				$image_output = wp_get_attachment_image( $id, $size, false );
			else
				$image_output = wp_get_attachment_link( $id, $size, true, false );
	
			$image_meta  = wp_get_attachment_metadata( $id );
	
			$orientation = '';
			if ( isset( $image_meta['height'], $image_meta['width'] ) )
				$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
	
			$output .= "<{$itemtag} class='gallery-item'>";
			$output .= "
				<{$icontag} class='gallery-icon {$orientation}'>
					$image_output
				</{$icontag}>";
			if ( $captiontag && trim($attachment->post_excerpt) ) {
				$output .= "
					<{$captiontag} class='wp-caption-text gallery-caption'>
					" . wptexturize($attachment->post_excerpt) . "
					</{$captiontag}>";
			}
			$output .= "</{$itemtag}>";
			if ( $columns > 0 && ++$i % $columns == 0 )
				$output .= '<br style="clear: both" />';
		}
	
		$output .= "
				<br style='clear: both;' />
			</div>\n";
		
		if( $ut_gallery_lightbox == "on" && empty( $attr['link'] ) ) {
			$output .= '<p>'.__('Lightbox has been deactivated. If you like to use the Lightbox Feature, please make sure you set "Link to" inside the Gallery Settings to "Media File"' , 'unitedthemes').'</p>';
		}
		
		if( $ut_gallery_lightbox == "on" && (! empty( $attr['link'] ) && 'file' === $attr['link']) ) {
		 
		 $output .= '<script type="text/javascript">/* <![CDATA[ */';		 
			 $output .= '(function($){ "use strict"; $(document).ready(function(){';
			 
			 $output .= "$('#$selector').magnificPopup({
					delegate: 'a',
					type: 'image',
					tLoading: '" . __('Loading image' , 'unitedthemes') . " #%curr%...',
					mainClass: 'mfp-img-mobile',
					gallery: {
						enabled: true,
						navigateByImgClick: true,
						preload: [0,1]
					},
					image: {
						tError: '<a href=\"%url%\">" . __('The Image' , 'unitedthemes') . " #%curr%</a> " . __('could not be loaded.' , 'unitedthemes') . "'
					}
				});";
			
			$output .= '}); })(jQuery);';
		 $output .= '/* ]]> */</script>';
		
		}
				
		return $output;
		
	}
	
	add_shortcode('gallery', 'ut_gallery_shortcode');
	
endif;


/*
|--------------------------------------------------------------------------
| Remove WP Gallery from content on single posts 
| we use get_post_gallery() instead
|--------------------------------------------------------------------------
*/

if ( ! function_exists( 'ut_remove_shortcode_from_posts' ) ) : 

	function ut_remove_shortcode_from_posts($content) {
		
		if( is_single() )
		$content = preg_replace( '/(.?)\[(gallery)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', '$1$6', $content );
		
		return $content;
		
	}
	
	add_filter('the_content', 'ut_remove_shortcode_from_posts'); 

endif; ?>