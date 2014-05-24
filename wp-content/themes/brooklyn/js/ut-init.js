/* <![CDATA[ */
(function($){
	
	"use strict";
	
    $(document).ready(function(){
		

		/* Main Navigation & Mobile Navigation
		================================================== */
		$('#navigation ul.menu').find(".current-menu-ancestor").each(function() { $(this).find("a").first().addClass("active"); }).end().find(".current_page_parent").each(function() { $(this).find("a").first().addClass("active"); }).end().superfish({autoArrows : true});
		$('#ut-mobile-menu').find(".current-menu-ancestor").each(function() { $(this).find("a").first().addClass("active"); }).end().find(".current_page_parent").each(function() { $(this).find("a").first().addClass("active"); });
		
		
		/* Mobile Navigation
		================================================== */
		$('#ut-mobile-menu .sub-menu li:last-child').addClass('last');
    	$('#ut-mobile-menu li:last-child').addClass('last');
		
		
		$("#ut-mobile-nav").hide();
		
		function mobile_menu_dimensions() {
			
			var nav_new_width	= $(window).width(),
				nav_new_height  = $(window).outerHeight();
			
			$("#ut-mobile-nav").width( nav_new_width ).height( nav_new_height );
			$(".ut-scroll-pane").width( nav_new_width + 17 ).height( nav_new_height );
		
		}
		
		function mobilemenu(){
                
			 if (($(window).width() > 979)) {
				$("#ut-mobile-nav").hide(); 
			 }
			
		}
		
		$(".ut-mm-trigger").click(function(event){
			
			$(this).toggleClass("active").next().slideToggle(500);
			mobile_menu_dimensions();
			
			event.preventDefault();
			
		});		
				
		var mobiletimer;
		
		$(window).resize(function(){
		  
		  clearTimeout(mobiletimer);
		  mobiletimer = setTimeout(mobilemenu, 100);
		  mobile_menu_dimensions();
		  
		});
		
		/* Tablet Slider
		================================================== */
		$(".ut-tablet-nav li a").click( function(event) {
			
			var index = $(this).parent().index();
						
			/* remove selected state from previuos tabs link */
			$(".ut-tablet-nav li").removeClass("selected");
			
			/* add class selected to current link */
			$(this).parent().addClass("selected");
			
			/* hide all tabs images */
			$(".ut-tablet").children().hide().removeClass("show");		
			
			/* show the selected tab image */
			$(".ut-tablet").children().eq(index).fadeIn("fast").addClass("show");
			
			event.preventDefault();
		
		});
		
		
		/* Fit Text
		================================================== */
		$(".ut-hero-style-5 .hero-title").fitText(0.3, { minFontSize: '30px', maxFontSize: '120px' });
		
		
		/* Scroll to Top
		================================================== */
		$('.logo a[href*=#]').click( function(event) { 
				
			event.preventDefault();			
			$.scrollTo( $(this).attr('href') , 650, { easing: 'easeInOutExpo' , offset: -80 , 'axis':'y' } );			
			
		});
		
		$('.toTop').click( function(event) { 
				
			event.preventDefault();			
			$.scrollTo( $(this).attr('href') , 650, { easing: 'easeInOutExpo' , offset: -80 , 'axis':'y' } );			
			
		});
		
		
		/* Scroll to main for hero buttons
		================================================== */
		$('#to-about-section').click( function( event ) {
			
			event.preventDefault();
			$.scrollTo( $('.wrap') , 650, {  easing: 'easeInOutExpo' , offset: -79 , 'axis':'y' } );
			
		});
		
		$('.hero-slider-button[href^="#"]').click( function( event ) {
			
			$.scrollTo( $(this).attr('href') , 650, {  easing: 'easeInOutExpo' , offset: -79 , 'axis':'y' } );
			event.preventDefault();
			
		});
		
		/* Scroll to Section if Hash exists
		================================================== */
		$(window).load(function() {
						
			if( window.location.hash ) {
				
				setTimeout ( function () {
																		
					$.scrollTo( window.location.hash , 650 , { easing: "easeInOutExpo" , offset: 0 , "axis":"y" } );
																		
				}, 400 );
								
			}
			
		});
		
		/* Scroll to Sections / Custom Links
		================================================== */
		$('.hero-slider-button[href^="#"]').click( function( event ) {
			
			$.scrollTo( this.hash , 650, { easing: 'easeInOutExpo' , offset: 0 , 'axis':'y' } );
			event.preventDefault();
			
		});
		
		/* Scroll to Sections / Main Menu
		================================================== */
		$('#navigation a').click( function(event) { 
						
			if(this.hash && !$(this).hasClass('external') ) {
			
				$.scrollTo( this.hash , 650, { easing: 'easeInOutExpo' , offset: 0 , 'axis':'y' } );			
				event.preventDefault();				
				
			} else if( this.hash && $(this).parent().hasClass('contact-us') ) {
				
				$.scrollTo( this.hash , 650, { easing: 'easeInOutExpo' , offset: 0 , 'axis':'y' } );			
				event.preventDefault();		
				
			}
			
		});
		
		/* Scroll to Sections / Mobile Menu
		================================================== */
		$('#ut-mobile-menu a').click( function(event) { 
			
			if(this.hash && !$(this).hasClass('external') ) {
				$.scrollTo( this.hash , 650, { easing: 'easeInOutExpo' , offset: 0 , 'axis':'y' } );			
				event.preventDefault();				
			}
			
			/* close menu */
			$('#ut-mobile-nav').slideToggle(500);
			
		});
		
		/* reflect scrolling in navigation
		================================================== */
		$('.ut-offset-anchor').each(function() {
        	
			$(this).waypoint( function( direction ) {
				
				if( direction === 'down' ) {
					
					var containerID = $(this).attr('id');
					
					if( $(this).data('parent') ) {
						containerID = $(this).data('parent');
					}

					/* update navigation */
					$('#navigation a').removeClass('selected');
					$('#navigation a[href*=#'+containerID+']').addClass('selected');
									
				}
							
			} , { offset: '80px' });
			  	  
        });
		
		$('.ut-scroll-up-waypoint').each(function() {
        	
			$(this).waypoint( function( direction ) {
				
				if( direction === 'up' ) {
					
					var containerID = $(this).data('section');
					
					if( $(this).data('parent') ) {
						containerID = $(this).data('parent');
					}

					/* update navigation */
					$('#navigation a').removeClass('selected');
					$('#navigation a[href*=#'+containerID+']').addClass('selected');
									
				}
							
			} , { offset: '82px' });
			  	  
        });	
		
		/* Parallax Effect - disabled for mobile devices
		================================================== */	
		if( !device.tablet() && !device.mobile() ) {			
						
			$('.parallax-banner').addClass('fixed').each(function() {                
				$(this).parallax( "50%", 0.6 ); 
			});
					
		}
		
		/* Youtube WMODE
		================================================== */
		$('iframe').each(function() {
			
			var url = $(this).attr("src");
			
			if ( url!=undefined ) {
				
				var youtube   = url.search("youtube"),			
					splitable = url.split("?");
				
				/* url has already vars */	
				if( youtube > 0 && splitable[1] ) {
					$(this).attr("src",url+"&wmode=transparent")
				}
				
				/* url has no vars */
				if( youtube > 0 && !splitable[1] ) {
					$(this).attr("src",url+"?wmode=transparent")
				}
			
			}
			
		});
		
		/* Member POPUP
		================================================== */
		var current_member = null;
		$('.ut-show-member-details').click( function(event) { 
		
			event.preventDefault();	
			
			/* show overlay */
			$('.ut-overlay').addClass('ut-overlay-show');			
			
			/* execute animation to make member visible */
			$('#member_'+$(this).data('member')).addClass('ut-box-show').animate( {top: "15%" , opacity: 1 } , 1000 , 'easeInOutExpo' , function() {
				
				var offset  = $(this).offset().top,
					id		= $(this).data("id");
					
				/* now append clone to body */
				$(this).clone().attr("id" , id).css({"position" : "absolute" , "top" : offset , "padding-top" : 0}).appendTo("body").addClass("member-clone");
			
				/* store current member ID */
				$(this).removeClass('ut-box-show').css({ "top" : "30%" , "opacity" : "0" });				
								
			});			
					
		});
		
		$(document).on("click" , '.ut-hide-member-details' , function(event) {
			
			event.preventDefault();
			
			/* execute animation to make member invisible */
			$('.ut-modal-box.member-clone').animate({top: "0%" , opacity: 0 } , 600 , 'easeInOutExpo' ,function() {
				
				$(this).remove();
				
				/* hide overlay */
				$('.ut-overlay').removeClass('ut-overlay-show');				
				
			});
			
		});
		
		$(document).on("click" , '.ut-overlay' , function(event) {
			
			event.preventDefault();
			
			/* execute animation to make member invisible */
			$('.ut-modal-box.member-clone').animate({top: "0%" , opacity: 0 } , 600 , 'easeInOutExpo' ,function() {
				
				$(this).remove();
				
				/* hide overlay */
				$('.ut-overlay').removeClass('ut-overlay-show');				
				
			});
			
		});				
		
		/* FitVid
		================================================== */
		$(".ut-video, .entry-content").fitVids();
		
		
		/* Lightbox Effect
		================================================== */		
		$('.ut-lightbox').prettyPhoto({
			social_tools : false,
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
											<p class="pp_description"></p> \
											<div class="ppt">&nbsp;</div> \
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
		
		/* Split Screen Calculation
		================================================== */
		$(window).load(function() {
			$(".ut-split-screen-poster").each(function() {
				
				var parent_ID = $(this).data("posterparent"),
					newHeight = $("#"+parent_ID).height();
				
				$(this).height(newHeight);			
				
			});
		});
		             	
	});
	
})(jQuery);
 /* ]]> */