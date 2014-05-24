/* <![CDATA[ */
(function($){
	
	"use strict";
	
    $(document).ready(function(){
        
        /* ------------------------------------------------
        display chosen portfolio settings type after load
        ------------------------------------------------ */
        $("#ut_portfolio_type").each(function(){
            
            var type = $(this).find(":selected").val();
            $('.ut-option-section').hide();
            
            if( type ) {
                $( '#' +  type + '_options' ).show();          
            }
            
        }); 
        
        
        /* ------------------------------------------------
        display chosen portfolio settings type on change
        ------------------------------------------------ */
        $("#ut_portfolio_type").change(function() {
        
            var type = $(this).find(":selected").val();
            $('.ut-option-section').hide();
            
            if( type ) {
                $( '#' +  type + '_options' ).show();          
            }   
        
        });
        
        
        /* ------------------------------------------------
        display image cropping settings after load
        ------------------------------------------------ */
        $("#ut_masonry_options_image_cropping").each(function() {
            
            if( $(this).is(':checked') ) {
                $("#ut_cropping_settings").show().css('display', 'inline-block');
            } else {
                $("#ut_cropping_settings").hide();
            }
                    
        });        
        
        
        /* ------------------------------------------------
        display image cropping settings on change 
        ------------------------------------------------ */
        $("#ut_masonry_options_image_cropping").change(function() {
            
            if( $(this).is(':checked') ) {
                $("#ut_cropping_settings").show().css('display', 'inline-block');
            } else {
                $("#ut_cropping_settings").hide();
            }
                    
        });
		
		
		/* ------------------------------------------------
        display image cropping settings after load
        ------------------------------------------------ */
        $("#ut_gallery_options_image_cropping").each(function() {
            
            if( $(this).is(':checked') ) {
                $("#ut_cropping_settings_gallery").show().css('display', 'inline-block');
            } else {
                $("#ut_cropping_settings_gallery").hide();
            }
                    
        });        
        
        
        /* ------------------------------------------------
        display image cropping settings on change 
        ------------------------------------------------ */
        $("#ut_gallery_options_image_cropping").change(function() {
            
            if( $(this).is(':checked') ) {
                $("#ut_cropping_settings_gallery").show().css('display', 'inline-block');
            } else {
                $("#ut_cropping_settings_gallery").hide();
            }
                    
        });
        
        /* ------------------------------------------------
        display image cropping settings after load
        ------------------------------------------------ */
        $("#ut_carousel_options_image_cropping").each(function() {
            
            if( $(this).is(':checked') ) {
                $("#ut_cropping_settings_carousel").show().css('display', 'inline-block');
            } else {
                $("#ut_cropping_settings_carousel").hide();
            }
                    
        });        
        
        
        /* ------------------------------------------------
        display image cropping settings on change 
        ------------------------------------------------ */
        $("#ut_carousel_options_image_cropping").change(function() {
            
            if( $(this).is(':checked') ) {
                $("#ut_cropping_settings_carousel").show().css('display', 'inline-block');
            } else {
                $("#ut_cropping_settings_carousel").hide();
            }
                    
        });
		
		
		/* ------------------------------------------------
		Color Picker 
        ------------------------------------------------ */
		$('.ut_color_picker').wpColorPicker();
		
		
		/* ------------------------------------------------
		Opacity Range Slider
        ------------------------------------------------ */
		var sliderdefault = $(".ut-opacity-slider").data('state');
		$( ".ut-opacity-slider" ).slider({
			
			min: 0,
			max: 1,
			step: 0.1,
			value: sliderdefault ,
			slide: function( event, ui ) {

				$(this).parent().find('.ut-hidden-slider-input').val( ui.value );
				$(this).parent().find('.ut-opacity-value').text( ui.value );
				
			}
		
		});
        
    });
    
})(jQuery);
 /* ]]> */	