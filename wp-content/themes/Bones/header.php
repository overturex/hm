<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // Google Chrome Frame for IE ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="<?php echo get_template_directory_uri(); ?>/library/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri(); ?>/library/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        
        <link href="<?php echo get_template_directory_uri(); ?>/library/css/hm.css" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri(); ?>/library/css/hm-responsive.css" rel="stylesheet">
        
        <link href="<?php echo get_template_directory_uri(); ?>/library/font-awesome/css/font-awesome.css" rel="stylesheet">

	</head>

	<body <?php body_class(); ?>>

		<div id="container">

			<header>  	
        <nav class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                	<div class="row">                  
                        <div class="span2">
                        	<div id="hm-logo-small">
                            	<img src="<?php echo get_template_directory_uri(); ?>/library/images/hm-logo-small.png">
                            </div>                          
                        </div>
                        <div class="span10">						                 
                            <div class="pull-left">
                            	<?php include "/navigation.php" ?>
                            </div>
                            
                            <div id="hm-info" class="pull-right">
                            	<a class="btn" href="#"><i class="fa fa-phone-square"></i> (604)-725-6303</a>
                                <span class="hm-info-divider"></span>
                                <a class="btn" href="#"><i class="fa fa-facebook-square"></i></a>
                                <span class="hm-info-divider"></span>
                                <a class="btn" href="#"><i class="fa fa-linkedin-square"></i></a>
                            </div>
                            
							<?php
                                /*$menu_name = "homelandmoving"; //e.g. primary-menu; $options['menu_choice'] in your case
                    
                                if ( ($menu = wp_get_nav_menu_object( $menu_name ) ) && ( isset($menu) ) ) {
                                    $menu_items = wp_get_nav_menu_items($menu->term_id);
                                    
                                    echo "<ul class='nav'>";
                                
                                    foreach ( (array) $menu_items as $key => $menu_item ) {
                                        $title = $menu_item->title;
                                        $url = $menu_item->url;
                                        
                                        
                                        echo "<li><a href='{$url}'>{$title}</a></li>";
                                    }
                                    
                                    echo "</ul>";
                                
                                    $menu_list .= '</ul>';
                                
                                } else {
                                
                                    $menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
                                    
                                    echo "what?";
                                }*/
                            ?>

                            
                        	
                        </div>
                    </div>
                </div>                
            </div>
            <div id="hm-logo-container">
                <div class="container"> 
                	<div class="row">
                    	<div class="span4">       	
                            <div id="hm-logo">
                                <img src="<?php echo get_template_directory_uri(); ?>/library/images/hm-logo.png">
                            </div>
                        </div>
                        <div class="span4">       	
                           
                        </div>
                        <div class="span4">       	
                            <div id="hm-boxes">
                                <img src="<?php echo get_template_directory_uri(); ?>/library/images/boxes.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>         	
        </nav>
    </header>
