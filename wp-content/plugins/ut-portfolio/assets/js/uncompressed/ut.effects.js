/* <![CDATA[ */
(function($){
	
	"use strict";
	
    $(document).ready(function(){
		
		/* Lightbox Effect
		================================================== */		
		$('a[data-rel^="utPortfolio"]').prettyPhoto({
			social_tools : false,
			deeplinking: false,
			default_width: 1024,
			allow_resize: true,
			markup: '<div class="pp_pic_holder"> \
						<div class="pp_top"> \
							<div class="pp_left"></div> \
							<div class="pp_middle"></div> \
							<div class="pp_right"></div> \
						</div> \
						<div class="pp_content_container"> \
							<div class="pp_left"> \
							<div class="pp_right"> \
								<div class="pp_content"> \
									<div class="pp_loaderIcon"></div> \
									<div class="pp_fade"> \
										<a href="#" class="pp_expand" title="Expand the image">Expand</a> \
										<div class="pp_hoverContainer"> \
											<a class="pp_next" href="#">next</a> \
											<a class="pp_previous" href="#">previous</a> \
										</div> \
										<div id="pp_full_res"></div> \
										<div class="pp_details"> \
											<div class="pp_nav"> \
												<a href="#" class="pp_arrow_previous">Previous</a> \
												<p class="currentTextHolder">0/0</p> \
												<a href="#" class="pp_arrow_next">Next</a> \
											</div> \
											<div class="ppt">&nbsp;</div> \
											<p class="pp_description"></p> \
											{pp_social} \
											<a class="pp_close" href="#">Close</a> \
										</div> \
									</div> \
								</div> \
							</div> \
							</div> \
						</div> \
						<div class="pp_bottom"> \
							<div class="pp_left"></div> \
							<div class="pp_middle"></div> \
							<div class="pp_right"></div> \
						</div> \
					</div> \
					<div class="pp_overlay"></div>',

		});
		
		/* Set Default Text Color for all elements */
		$(".ut-hover").each(function(index, element) {
            
			var text_color = $(this).closest('.ut-portfolio-wrap').data('textcolor');
			
			$(this).find(".ut-hover-layer").css({ "color" : text_color });
			$(this).find(".ut-hover-layer").find('.portfolio-title').attr('style', 'color: '+text_color+' !important');
			
        });		
		
		$(".ut-hover").mouseenter(function() {
			
			var hover_color   = $(this).closest('.ut-portfolio-wrap').data('hovercolor'),
				hover_opacity = $(this).closest('.ut-portfolio-wrap').data('opacity');

			$(this).find(".ut-hover-layer").css( "background" , "rgba(" + hover_color + "," + hover_opacity+ ")"  );
			$(this).find(".ut-hover-layer").css( "opacity" , 1 );			
			
		}).mouseleave(function() {
			
			$(this).find(".ut-hover-layer").css( "opacity" , 0 );
			
		});
			
		/* Update portfolio height */
		function update_portfolio_height( wrap , direction ) {
			
			if( !wrap ) {
				return;
			} 			
			
			var height = null;
			
			if( direction === 'prev' ) {
				height = $('#ut-portfolio-details-'+wrap).find('.active').prev().height();
			}
			
			if( direction === 'current' ) {
				height = $('#ut-portfolio-details-'+wrap).find('.active').height();
			}
			
			if( direction === 'next' ) {
				height = $('#ut-portfolio-details-'+wrap).find('.active').next().height();
			}
			
			$('#ut-portfolio-details-wrap-'+wrap).height( height + 30 );
			
		}
		
		/* Update the Portfolio Detail Navigation */
		function update_portfolio_navigation( wrap ) {
						
			if( !wrap ) {
				return;
			} 
			
			/* lets get the next and previous element */
			var prev = $('#ut-portfolio-details-'+wrap).find('.active').prev('.ut-portfolio-detail'),
				next = $('#ut-portfolio-details-'+wrap).find('.active').next('.ut-portfolio-detail');
			
			/* show or hide previous button */
			if( !prev.length ) {
				$('#ut-portfolio-details-wrap-'+wrap).find('.prev-portfolio-details').hide();
			} else {
				$('#ut-portfolio-details-wrap-'+wrap).find('.prev-portfolio-details').show();
			}
			
			/* show or hide next button */ 
			if( !next.length ) {
				$('#ut-portfolio-details-wrap-'+wrap).find('.next-portfolio-details').hide();
			} else {
				$('#ut-portfolio-details-wrap-'+wrap).find('.next-portfolio-details').show();
			}
			
			update_portfolio_navigation_position();
								
		}	
		
		
		function update_portfolio_navigation_position() {
			
			$('.ut-portfolio-details-navigation').each(function() {
                
				var $this 			= $(this),
					$parent 		= $this.parent(),
					$current 		= $parent.find(".active"),					
					media_height 	= $current.find(".ut-portfolio-media").height();
					
					$this.find('.next-portfolio-details').animate({top: media_height / 2 + 45 });
					$this.find('.prev-portfolio-details').animate({top: media_height / 2 + 45 });
					
				
            });
						
		}
		
		
		$(window).smartresize(function(){
			update_portfolio_navigation_position();
		});
		
		
		
		/* show portfolio detail */
		$(document).on("click", ".ut-portfolio-link", function(event) { 
			
			var portfolio_wrap = $(this).data('wrap'),
				$portfolio_wrap_obj = $('#ut-portfolio-details-wrap-'+portfolio_wrap),
				section_width = $portfolio_wrap_obj.closest('section').data('width'),
				portfolio_id = $(this).data('post'),
				extraClass = '';
			
			$.scrollTo( $portfolio_wrap_obj , 650 , {  easing: 'easeInOutExpo' , offset: -100 , 'axis':'y' , onAfter:function(){ 
				
				/* we need some extra padding for fullwidth layouts / sections */
				if( section_width !== 'centered' ) {
					extraClass = 'grid-container';
				}
				
				/* hide all portfolio item first */
				$portfolio_wrap_obj.find('.ut-portfolio-detail').hide().removeClass('active');
				
				$portfolio_wrap_obj.addClass('show').find('.ut-portfolio-details').addClass(extraClass);
				$portfolio_wrap_obj.find('#ut-portfolio-detail-'+portfolio_id).fadeIn(800 , 'easeInOutExpo' , function() {
					
					/* remove overflow hidden */
					$portfolio_wrap_obj.addClass('overflow-visible');
					//update_portfolio_height( portfolio_wrap , 'current');
										
					/* box holds a slider , so we need to "recall" it */
					if( $portfolio_wrap_obj.find('#ut-portfolio-detail-'+portfolio_id).data("format") === 'gallery' ) {
						utInitFlexSlider( portfolio_id );	
					}
					
					/* update portfolio detail navigation */
					update_portfolio_navigation( portfolio_wrap );
					
					/* now show the portfolio navigation*/
					$portfolio_wrap_obj.find('.ut-portfolio-details-navigation').addClass('show');
					

				}).addClass('active');
								
				
			}});
			
			event.preventDefault();
			
		});
		
		
		/* next portfolio item */
		$(document).on("click", ".next-portfolio-details", function(event) { 
			
			var portfolio_wrap = $(this).data('wrap');
			
			//update_portfolio_height( portfolio_wrap , 'next');
			$('#ut-portfolio-details-'+portfolio_wrap).find('.active').hide().removeClass('active').next().fadeIn(1000  , 'easeInOutExpo').addClass('active');	
			
			/* box holds a slider , so we need to "recall" it */
			if( $('#ut-portfolio-details-'+portfolio_wrap).find('.active').data("format") === 'gallery' ) {				
				utInitFlexSlider( $('#ut-portfolio-details-'+portfolio_wrap).find('.active').data("post") );				
			}
			
			/* update portfolio detail navigation */
			update_portfolio_navigation( portfolio_wrap );
						
			event.preventDefault();
			
		});
		
		
		/* prev portfolio item */
		$(document).on("click", ".prev-portfolio-details", function(event) { 
			
			var portfolio_wrap = $(this).data('wrap');
			
			//update_portfolio_height( portfolio_wrap , 'prev');
			$('#ut-portfolio-details-'+portfolio_wrap).find('.active').hide().removeClass('active').prev().fadeIn(1000 , 'easeInOutExpo').addClass('active');
			
			/* box holds a slider , so we need to "recall" it */
			if( $('#ut-portfolio-details-'+portfolio_wrap).find('.active').data("format") === 'gallery' ) {
				utInitFlexSlider( $('#ut-portfolio-details-'+portfolio_wrap).find('.active').data("post") );
			}
			
			/* update portfolio detail navigation */
			update_portfolio_navigation( portfolio_wrap );
						
			event.preventDefault();
		
		});
		
		
		/* close portfolio detail */
		$(document).on("click", ".close-portfolio-details", function(event) { 
			
			var portfolio_wrap = $(this).data('wrap'),
				portfolio_id = $(this).data('post');
				
			$('#ut-portfolio-details-wrap-'+portfolio_wrap).removeClass('show').removeClass('overflow-visible');
			$('#ut-portfolio-details-wrap-'+portfolio_wrap).find('.ut-portfolio-details-navigation').removeClass('show');
			$('#ut-portfolio-detail-'+portfolio_id).hide();
			
			event.preventDefault();
		
		});
		
		
		/* activate portfolio single slider */
		function utInitFlexSlider( postID ) {
			
			if(!postID) {
				return;
			}
			
			$('#portfolio-gallery-slider-'+postID).flexslider({
					
					animation: 'fade',
					controlNav: false,
                    animationLoop: true,
                   	slideshow: false,
					smoothHeight: true,
					startAt: 0,
					after: function(){
						update_portfolio_navigation_position();
					}
										
			});			
		
		}
		
	});
    
})(jQuery);
 /* ]]> */	