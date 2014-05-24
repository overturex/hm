<ul class="nav">
	<?php 
        $menu_name = "homelandmoving"; 
        
        $menu = wp_get_nav_menu_object($menu_name);
        
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        //echo "{" . count($menu_items) . "}";
        
        foreach ($menu_items as $menu_item ) {
            echo '<li>';
            echo $menu_item->title;
            
            $submenu = array();
            
            foreach($menu_items as $child){
              if($child->menu_item_parent == $menu_item->ID)
                 $submenu[] = $child;
            }
			
			if(count($submenu) > 0){
				$submenu_list = '<div class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Dropdown trigger</a><ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';				
				
				foreach($submenu as $submenu_item){					
					$submenu_list = $submenu_list . '<li><a tabindex="-1" href="#">' . $submenu_item -> title . '</a></li>';
				}
				
				$submenu_list = $submenu_list . '</ul></div>';
				
				echo $submenu_list;
			}
			
			echo '</li>';

        }
    ?>
</ul>