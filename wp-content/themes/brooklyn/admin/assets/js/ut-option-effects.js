/* <![CDATA[ */
(function($){
	
	"use strict";
		
    $(document).ready(function(){
		
		/* ui select groups */
		$(".option-tree-ui-group-select").each(function(){
			
			var current_for = $(this).find(':selected').data('for');
			
			$(this).children("option").each(function() {
                
				/* hide other elements */
				if( $(this).data("for") !== 'current_for') {
					$("#setting_"+ $(this).data("for") ).hide();
				}
				
            });
			
			$("#setting_"+ current_for ).show();
			
		});
		
		$(".option-tree-ui-group-select").change(function(){
			
			var current_for = $(this).find(':selected').data('for');
			
			$(this).children("option").each(function() {
                
				/* hide other elements */
				if( $(this).data("for") !== 'current_for') {
					$("#setting_"+ $(this).data("for") ).hide();
				}
				
            });
			
			$("#setting_"+ current_for ).show();
			
		});
		
		
		
		/* google font integration */
		var update_google_font_link = function( group ) {
			
			if(!group) {
				return;
			}
			
			var $this		= $("#"+group+"-font-family"),
				url 		= 'http://fonts.googleapis.com/css?family=',
				family  	= $this.find(':selected').data('family'),
				font_weight	= $("#"+group+"-font-weight").val(),
				font_style	= $("#"+group+"-font-style").val();		
			
			$("#ut-google-style-link-"+group).attr("href" , url+family+':'+font_weight+font_style);
		
		}
		
		var update_google_font_preview = function( group , font_size , font ) {
			
			$("#ut-google-style-"+group).text('#ut-google-preview-'+group+' { font-size: '+font_size+'; font-family: "'+ font +'" !important; }');
		
		}
		
		var update_google_font_subsets = function( group , subsets ) {
			
			var subsets = subsets.split(","); 
			
			/* reset select field if selected state is not available anymore */		
			if( $.inArray( $("#"+group+"-font-subset").val() , subsets ) === -1 ) {
				$("#"+group+"-font-subset").prop('selectedIndex', 0).prev('span').replaceWith('<span>' + $("#"+group+"-font-subset").find('option:selected').text() + '</span>');
			}
			
			/* update available subsets */
			$("#"+group+"-font-subset option").each(function() {
				
				if( $.inArray( $(this).val() , subsets ) >= 0 || !$(this).val() ) {
					
					$(this).attr("disabled" , false);
					
				} else {
				
					$(this).attr("disabled" , true);
					
				}
				
			});
		
		}	
		
		var update_google_font_weights = function( group , variants ) {
			
			var variants = variants.split(",");
						
			/* reset select field if selected state is not available anymore */	
			if( $.inArray( $("#"+group+"-font-weight").val() , variants ) === -1 ) {
				$("#"+group+"-font-weight").prop('selectedIndex', 0).prev('span').replaceWith('<span>' + $("#"+group+"-font-weight").find('option:selected').text() + '</span>');
			}
			
			$("#"+group+"-font-weight option").each(function() {
				
				if( $.inArray( $(this).val() , variants ) >= 0 || !$(this).val() ) {
				
					$(this).attr("disabled" , false);
				
				} else {
				
					$(this).attr("disabled" , true);
								
				}
					
			});
		}		
		
		var update_google_font_styles = function( group , variants ) {
		
			var variants = variants.split(",");
			
			/* reset select field if selected state is not available anymore */	
			if( $.inArray( $("#"+group+"-font-style").val() , variants ) === -1 ) {
				$("#"+group+"-font-style").prop('selectedIndex', 0).prev('span').replaceWith('<span>' + $("#"+group+"-font-style").find('option:selected').text() + '</span>').show("highlight");
			}
			
			$("#"+group+"-font-style option").each(function() {
				
				if( $.inArray( $(this).val() , variants ) >= 0 || !$(this).val() ) {
				
					$(this).attr("disabled" , false);
				
				} else {
				
					$(this).attr("disabled" , true);
								
				}			
			
			});
		
		}
		
		var update_google_font_fields = function( group ) {
			
			if(!group) {
				return;
			}
			
			var $this		= $("#"+group+"-font-family"),
				font 		= $this.find(':selected').data('font'),
				subsets		= $this.find(':selected').data('subsets'),
				family  	= $this.find(':selected').data('family'),
				variants	= $this.find(':selected').data('variants'),
				font_id		= $this.find(':selected').data('fontid'),
				font_size	= $("#"+group+"-font-size").val(),
				font_weight	= $("#"+group+"-font-weight").val(),
				font_style	= $("#"+group+"-font-style").val();			
			
			if( font ) {
			
				/* update subsets */			
				update_google_font_subsets( group , subsets );
				
				/* update weights*/
				update_google_font_weights( group , variants );
				
				/* update styles*/
				update_google_font_styles( group , variants );
				
				/* change link attr */
				update_google_font_link( group );
							
				/* update font preview */
				update_google_font_preview( group , font_size , font );		
				
				/* update hidden ID */
				$("#"+group+"-fontid").val(font_id);
				
			}
			
		}
		
		/* update all fields first */
		$(".ut-google-font-select").each(function() {
            
			var group = $(this).data("group");
								
			/* update fields */
			update_google_font_fields( group );
			
        });
		
		
		$(".ut-google-font-select").change(function(){
			
			var group = $(this).data("group");
								
			/* update fields */
			update_google_font_fields( group );
			
		});
		
		
		$(".ut-google-font-size").change(function(){
			
			var group = $(this).data("group");
					
			/* update fields */
			update_google_font_fields( group );
			
		});
		
		$(".ut-google-font-weight").change(function(){
			
			var group = $(this).data("group");
								
			/* update fields */
			update_google_font_fields( group );
			
		});
		
		$(".ut-google-font-style").change(function(){
			
			var group = $(this).data("group");
					
			/* update fields */
			update_google_font_fields( group );
			
		});
		
		
		/* thick box enhancement */		
		tb_position = function() {
			var tbWindow = $('#TB_window');
			var width = 840;
			var H = 600;
			var W = width;
	
			if ( tbWindow.size() ) {
				tbWindow.width( W - 50 ).height( H - 45 );
				$('#TB_iframeContent').width( W - 50 ).height( H - 75 );
				tbWindow.css({'margin-left': '-' + parseInt((( W - 50 ) / 2),10) + 'px'});
				if ( typeof document.body.style.maxWidth != 'undefined' )
					tbWindow.css({'top':'40px','margin-top':'0'});
			};
	
			return $('a.thickbox').each( function() {
				var href = $(this).attr('href');
				if ( ! href ) return;
				href = href.replace(/&width=[0-9]+/g, '');
				href = href.replace(/&height=[0-9]+/g, '');
				$(this).attr( 'href', href + '&width=' + ( W - 80 ) + '&height=' + ( H - 85 ) );
			});
		};
	
		$('a.thickbox').click(function(){
			if ( typeof tinyMCE != 'undefined' &&  tinyMCE.activeEditor ) {
				tinyMCE.get('content').focus();
				tinyMCE.activeEditor.windowManager.bookmark = tinyMCE.activeEditor.selection.getBookmark('simple');
			}
		});
		
		/* show font style */
		$('.ut-font-preview').click( function() {
			
			tb_show('', ut_font_popup.pop_url + 'fontpreview.html?TB_iframe=true');
 			return false;
			
		});
				
		/* show header style */
		$('.ut-header-preview').click( function() {
			
			tb_show('', ut_font_popup.pop_url + 'headerpreview.html?TB_iframe=true');
 			return false;
			
		});
		
		/* show header style */
		$('.ut-hero-preview').click( function() {
			
			tb_show('', ut_font_popup.pop_url + 'heropreview.html?TB_iframe=true');
 			return false;
			
		});	
		
		
		/* hide or show boxed an option tree load */
		var front_header_setting = $('#ut_front_page_header_type').val(),
			blog_header_setting  = $('#ut_blog_header_type').val();
		
		
		function show_hide_front_header_settings( setting_name ) {
			
			if( setting_name === 'image' ) {
				
				/* hide other settings*/
				hide_front_slider_settings();
				hide_front_tabs_settings();
				$('#setting_front_hero_custom_shortcode').hide();
				$('#setting_front_hero_dynamic_content').hide();
				
				/* show settings */
				$('#setting_ut_front_header_image').show();
				$('#setting_ut_front_header_parallax').show();				
				
			} else if( setting_name === 'slider' ) {
				
				/* hide other settings*/
				hide_front_tabs_settings();
				$('#setting_front_hero_custom_shortcode').hide();
				$('#setting_front_hero_dynamic_content').hide();				
				$('#setting_ut_front_header_image').hide();
				$('#setting_ut_front_header_parallax').hide();
				
				/* show settings */
				show_front_slider_settings();
				
				
			} else if( setting_name === 'video' ) {
				
				/* hide other settings*/
				hide_front_slider_settings();
				hide_front_tabs_settings();
				
				$('#setting_ut_front_header_image').hide();
				$('#setting_ut_front_header_parallax').hide();
				$('#setting_front_hero_custom_shortcode').hide();
				$('#setting_front_hero_dynamic_content').hide();
						
			} else if( setting_name === 'tabs' ) {
				
				/* hide other settings*/
				hide_front_slider_settings();
				
				$('#setting_front_hero_custom_shortcode').hide();
				$('#setting_front_hero_dynamic_content').hide();
				
				/* show settings */
				$('#setting_ut_front_header_image').show();
				$('#setting_ut_front_header_parallax').show();
				
				show_front_tabs_settings();				
						
			} else if( setting_name === 'custom' ) {
			
				/* hide other settings*/
				hide_front_slider_settings();
				hide_front_tabs_settings();
				
				$('#setting_ut_front_header_image').hide();
				$('#setting_ut_front_header_parallax').hide();
				$('#setting_front_hero_dynamic_content').hide();
				
				/* show settings */
				$('#setting_front_hero_custom_shortcode').show();
			
			} else if( setting_name === 'dynamic' ) {
				
				/* hide other settings*/
				hide_front_slider_settings();
				hide_front_tabs_settings();
				
				$('#setting_ut_front_header_image').hide();
				$('#setting_ut_front_header_parallax').hide();
				$('#setting_front_hero_custom_shortcode').hide();
								
				/* show settings */
				$('#setting_front_hero_dynamic_content').show();
				
			}
			
			
		}
		
		function show_hide_blog_header_settings( setting_name ) {
			
			if( setting_name === 'image' ) {
				
				/* hide other settings*/
				hide_blog_slider_settings();
				hide_blog_tabs_settings();
				$('#setting_blog_hero_custom_shortcode').hide();
				$('#setting_blog_hero_dynamic_content').hide();				
				
				/* show settings */
				$('#setting_ut_blog_header_image').show();
				$('#setting_ut_blog_header_parallax').show();
				
			} else if( setting_name === 'slider' ) {
				
				/* hide other settings*/
				hide_blog_tabs_settings();
				$('#setting_ut_blog_header_image').hide();
				$('#setting_ut_blog_header_parallax').hide();
				$('#setting_blog_hero_custom_shortcode').hide();
				$('#setting_blog_hero_dynamic_content').hide();	
				
				/* show settings */
				show_blog_slider_settings();
				
				
			} else if( setting_name === 'video' ) {
				
				/* hide other settings*/
				hide_blog_slider_settings();
				hide_blog_tabs_settings();
				$('#setting_ut_blog_header_image').hide();
				$('#setting_ut_blog_header_parallax').hide();
				$('#setting_blog_hero_custom_shortcode').hide();		
				$('#setting_blog_hero_dynamic_content').hide();	
						
			} else if( setting_name === 'tabs' ) {
				
				/* hide other settings*/
				hide_blog_slider_settings();
				$('#setting_blog_hero_custom_shortcode').hide();
				$('#setting_blog_hero_dynamic_content').hide();				
				
				/* show settings */
				show_blog_tabs_settings();
			
			} else if( setting_name === 'custom' ) {
				
				/* hide other settings*/
				hide_blog_slider_settings();
				hide_blog_tabs_settings();
				$('#setting_ut_blog_header_image').hide();
				$('#setting_ut_blog_header_parallax').hide();
				$('#setting_blog_hero_dynamic_content').hide();		
				
				/* show settings */
				$('#setting_blog_hero_custom_shortcode').show();				
						
			}  else if( setting_name === 'dynamic' ) {
				
				/* hide other settings*/
				hide_blog_slider_settings();
				hide_blog_tabs_settings();
				$('#setting_ut_blog_header_image').hide();
				$('#setting_ut_blog_header_parallax').hide();
				$('#setting_blog_hero_custom_shortcode').hide();	
				
				/* show settings */				
				$('#setting_blog_hero_dynamic_content').show();	
			
			}
			
		}
		
		function hide_front_tabs_settings() {
			
			$('#setting_ut_front_page_tabs_headline').hide();
			$('#setting_ut_front_page_tabs_headline_style').hide();
			$('#setting_ut_front_page_tabs').hide();
			
		}
		
		function show_front_tabs_settings() {
			
			$('#setting_ut_front_page_tabs_headline').show();
			$('#setting_ut_front_page_tabs_headline_style').show();
			$('#setting_ut_front_page_tabs').show();
			
		}		
		
		function hide_front_slider_settings() {
			
			$('#setting_front_page_slider_management').hide();
			$('#setting_front_animation').hide();
			$('#setting_front_animation_speed').hide();
			$('#setting_front_slideshow_speed').hide();
			$('#setting_ut_front_page_slider').hide();
			
		}
		
		function show_front_slider_settings() {
			
			$('#setting_front_page_slider_management').show();
			$('#setting_front_animation').show();
			$('#setting_front_animation_speed').show();
			$('#setting_front_slideshow_speed').show();
			$('#setting_ut_front_page_slider').show();
			
		}
		
		function hide_blog_slider_settings() {
			
			$('#setting_blog_page_slider_management').hide();
			$('#setting_blog_animation').hide();
			$('#setting_blog_animation_speed').hide();
			$('#setting_blog_slideshow_speed').hide();
			$('#setting_ut_blog_slider').hide();
			
		}
		
		function show_blog_slider_settings() {
			
			$('#setting_blog_page_slider_management').show();
			$('#setting_blog_animation').show();
			$('#setting_blog_animation_speed').show();
			$('#setting_blog_slideshow_speed').show();
			$('#setting_ut_blog_slider').show();
			
		}
		
		function hide_blog_tabs_settings() {
			
			$('#setting_ut_blog_tabs_headline').hide();
			$('#setting_ut_blog_tabs_headline_style').hide();
			$('#setting_ut_blog_tabs').hide();
			
		}
		
		function show_blog_tabs_settings() {
			
			$('#setting_ut_blog_tabs_headline').show();
			$('#setting_ut_blog_tabs_headline_style').show();
			$('#setting_ut_blog_tabs').show();
			
		}
		
		
		/* on page call */
		show_hide_front_header_settings( front_header_setting );
		show_hide_blog_header_settings( blog_header_setting );
		
		/* on change */
		$('#ut_front_page_header_type').change( function() {
			
			var front_header_setting = $(this).val();
			show_hide_front_header_settings( front_header_setting );
		
		});
		
		$('#ut_blog_header_type').change( function() {
			
			var blog_header_setting = $(this).val();
			show_hide_blog_header_settings( blog_header_setting );
			
		
		});
		
		
		/* disable background settings of parallax is active // front page */
		var parallax_status = $("#ut_front_header_parallax").val();
				
		if( parallax_status === 'on' ) {
			
			$("#ut_front_header_image-attachment").prop('selectedIndex', 0);
			$("#ut_front_header_image-attachment").attr("disabled", true ).parent().wrap('<div class="disabled" />');
			
			$("#ut_front_header_image-position").prop('selectedIndex', 0);
			$("#ut_front_header_image-position").attr("disabled", true ).parent().wrap('<div class="disabled" />');
		
		}
		
		$("#ut_front_header_parallax").change(function() { 
		
			parallax_status = $(this).val();
			
			if( parallax_status === 'on' ) {
				
				$("#ut_front_header_image-attachment").prop('selectedIndex', 0).trigger("change");
				$("#ut_front_header_image-attachment").attr("disabled", true ).parent().wrap('<div class="disabled" />');
				
				$("#ut_front_header_image-position").prop('selectedIndex', 0).trigger("change");
				$("#ut_front_header_image-position").attr("disabled", true ).parent().wrap('<div class="disabled" />');
							
			} else {
				
				$("#ut_front_header_image-attachment").attr("disabled", false ).parent().unwrap();				
				$("#ut_front_header_image-position").attr("disabled", false ).parent().unwrap();			
			
			}			
		
		});
		
		/* disable background settings of parallax is active // blog */
		var parallax_status = $("#ut_blog_header_parallax").val();
				
		if( parallax_status === 'on' ) {
			
			$("#ut_blog_header_image-attachment").prop('selectedIndex', 0);
			$("#ut_blog_header_image-attachment").attr("disabled", true ).parent().wrap('<div class="disabled" />');
			
			$("#ut_blog_header_image-position").prop('selectedIndex', 0);
			$("#ut_blog_header_image-position").attr("disabled", true ).parent().wrap('<div class="disabled" />');
		
		}
		
		$("#ut_front_header_parallax").change(function() { 
		
			parallax_status = $(this).val();
			
			if( parallax_status === 'on' ) {
				
				$("#ut_blog_header_image-attachment").prop('selectedIndex', 0).trigger("change");
				$("#ut_blog_header_image-attachment").attr("disabled", true ).parent().wrap('<div class="disabled" />');
				
				$("#ut_blog_header_image-position").prop('selectedIndex', 0).trigger("change");
				$("#ut_blog_header_image-position").attr("disabled", true ).parent().wrap('<div class="disabled" />');
							
			} else {
				
				$("#ut_blog_header_image-attachment").attr("disabled", false ).parent().unwrap();				
				$("#ut_blog_header_image-position").attr("disabled", false ).parent().unwrap();			
			
			}			
		
		});
		
		
		/* disable background settings of parallax is active // contact section */
		var parallax_status = $("#ut_csection_parallax").val();
				
		if( parallax_status === 'on' ) {
			
			$("#ut_csection_background_image-attachment").prop('selectedIndex', 0);
			$("#ut_csection_background_image-attachment").attr("disabled", true ).parent().wrap('<div class="disabled" />');
			
			$("#ut_csection_background_image-position").prop('selectedIndex', 0);
			$("#ut_csection_background_image-position").attr("disabled", true ).parent().wrap('<div class="disabled" />');
		
		}
		
		$("#ut_csection_parallax").change(function() { 
		
			parallax_status = $(this).val();
			
			if( parallax_status === 'on' ) {
				
				$("#ut_csection_background_image-attachment").prop('selectedIndex', 0).trigger("change");
				$("#ut_csection_background_image-attachment").attr("disabled", true ).parent().wrap('<div class="disabled" />');
				
				$("#ut_csection_background_image-position").prop('selectedIndex', 0).trigger("change");
				$("#ut_csection_background_image-position").attr("disabled", true ).parent().wrap('<div class="disabled" />');
							
			} else {
				
				$("#ut_csection_background_image-attachment").attr("disabled", false ).parent().unwrap();				
				$("#ut_csection_background_image-position").attr("disabled", false ).parent().unwrap();			
			
			}			
		
		});
		
		
		
		
		
	});

})(jQuery);
 /* ]]> */	