			<footer class="footer" role="contentinfo">
            	<div class="container">
                    <div id="inner-footer" class="wrap clearfix">
    
                        <nav role="navigation">
                                <?php bones_footer_links(); ?>
                        </nav>
    
                        <p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?></p>
    
                    </div>
                </div>
			</footer>

		</div>

		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo get_template_directory_uri(); ?>/library/bootstrap/js/bootstrap.min.js"></script>
    
    <script>
		var scrolled = false;
	
		$(document).scroll(function() {
			console.log($(document).scrollTop());
			
			if($(document).scrollTop() > 100 && !scrolled){
				//$("#hm-logo").hide(("slide", { direction: "up" }, 1000);)
				$('.navbar-fixed-top').animate({'top':'0px'}, 1000, function(){$('#hm-logo-small').show();});
				
				scrolled = true;
				
			}
			else if($(document).scrollTop() == 0){
				$(document).scrollTop(0);
				$('.navbar-fixed-top').animate({'top':'100px'}, 1000);
				$('#hm-logo-small').fadeOut(1000);
				scrolled = false;
				$('.nav li a').css({'color':'inherit'});
				
			}
		});		
		
	</script>
    
    <script>
		$(document).ready(function() {
			$('.nav li a').click(function(e){
				
				scrolled = true; 
				
				var target = $(this).attr('href');
				var top = $(target).offset().top;
				//$("#hm-logo").hide();
				$(".navbar-fixed-top").animate({'top':'0px'});
				$('html,body').animate({scrollTop: (top - 47) + "px"}, 1000, function(){});
				
				$('#hm-logo-small').fadeIn(1000);
				$('.nav li a').css({'color':'inherit'});
				$(this).css({'color':'#f89304'});
				
				
				return false;
			});
		 });
	</script>
    
    <script>
		$('.hm-guide').click(function(){
			$('html,body').animate({scrollTop: 0}, 1000, function(){});
			
			return false;			
		});
	</script>
    
    <script>
		$(".hm-page").each(function(){
			if($(this).height() < window.innerHeight){
				var newHeight = window.innerHeight - $(this).height() - 40;
				$(this).css({'padding-top': newHeight/2});
				$(this).css({'padding-bottom': newHeight/2});
			}
		});
            
        
	</script>
		
	</body>

</html>
