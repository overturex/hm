<?php get_header(); ?>

<a href="#" class="hm-guide"><i class="fa fa-chevron-up"></i></a>

<?php 

$template_directory = get_template_directory_uri();
$homepageText = '


    	<div class="row">
        	<div class="span4">
            	<div class="row">
                	<div class="span2">
                    	<div class="hm-button-container hm-button-container-left">
                        	<a href="#">
                            <img class="img-polaroid img-rounded" src="' . $template_directory . '/library/images/residential.png">
                            </a>
                            <a class="hm-button hm-button-left btn btn-warning" href="#">Residential Moving</a>
                        </div>                       
                    </div>
                    <div class="span2">
                    	<div class="hm-button-container hm-button-container-right">
                        	<a href="#">
                            <img class="img-polaroid img-rounded" src="' . $template_directory . '/library/images/commercial.png">
                            </a>
                            <a class="hm-button hm-button-right btn btn-success" href="#">Commercial Moving</a>
                        </div>                       
                    </div>
                </div>
                <div class="spacer"></div>
                <div class="row">
                	<div class="span2">
                    	<div class="hm-button-container hm-button-container-left">
                        	<a href="#">
                            <img class="img-polaroid img-rounded" src="' . $template_directory . '/library/images/auto.png">
                            </a>
                            <a class="hm-button hm-button-left btn btn-warning" href="#">Auto Moving</a>
                        </div>                       
                    </div>
                    <div class="span2">
                    	<div class="hm-button-container hm-button-container-right">
                        	<a href="#">
                            <img class="img-polaroid img-rounded" src="' . $template_directory . '/library/images/storage.png">
                            </a>
                            <a class="hm-button hm-button-right btn btn-success" href="#">Storage Services</a>
                        </div>                       
                    </div>
                </div>
            </div>
            
            <div class="span8">
            	<div id="hm-motto">
                	<h1>
                    	<span class="hm-text-white">we make</span>
                        <span class="hm-text-green">your house</span>
                    </h1>
                    <h1>
                    	<span class="hm-text-white">into a</span>
                        <span class="hm-text-orange">home!</span>
                    </h1>
                    <p class="hm-text-white">Affordable moving service that anyone can customize to fit their needs.</p>
                </div>
            </div>    	
    	</div>
	

';

?>


<?php
	$pahe_html = 

	$menu_name = "homelandmoving"; 
	
	if ( ($menu = wp_get_nav_menu_object( $menu_name ) ) && ( isset($menu) ) ) {
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		
		$i = 1;
		$page_class = "";
		
		foreach ( (array) $menu_items as $key => $menu_item ) {
			$title = $menu_item->title;
			$url = $menu_item->url;
			$page = get_page_by_title( $title );
			
			if($i % 2 == 0){
				$page_class = "hm-page-odd";
			}
			else{
				$page_class = "hm-page-even";
			}
			
			if($i == 1){
				$page_class = "hm-home";
				
				
				echo "<div class='hm-page {$page_class}' id='hm_page{$i}'>";
				echo '<div class="container"><div class="row"><div class="span12">';
				echo $homepageText;
				echo "<div class='hm-home-divider'></div>";	
				echo apply_filters('the_content', $page->post_content);
				echo '</div></div></div>';
				echo '</div>';
			}
			else{
				echo "<div class='hm-page {$page_class}' id='hm_page{$i}'>";
				echo '<div class="container"><div class="row"><div class="span12">';
				echo "<h1 class='hm-page-title'>{$title}</h1>";			
				echo apply_filters('the_content', $page->post_content);
				echo '</div></div></div>';
				echo '</div>';
			}
			
			$i++;
			
		}
	}
?>


<?php get_footer(); ?>
