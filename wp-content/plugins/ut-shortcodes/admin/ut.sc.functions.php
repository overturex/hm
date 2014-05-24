<?php

/*
|--------------------------------------------------------------------------
| generate shortcode config element
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_get_option_element' ) ) {

	function ut_get_option_element( $name, $attr_opt, $type, $code ){
		
		$return = '';
				
		switch( $attr_opt['type'] ){
			
			case 'radio' : return ut_generate_radio_option( $name, $attr_opt, $type, $code ); 
			break;
		
			case 'select': return ut_generate_select_option( $name, $attr_opt, $type, $code ); 
			break;
			
		case 'custom':
	 
			if( $name == 'tabgroup' ) {
				$return .= '<p><label>'.__( 'Manage Tabs' , 'ut_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-list-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-lister well-white">';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Title' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<input data-group="tabgroup" class="sc-list-item form-control propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Tab Content' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<textarea data-group="tabgroup" class="sc-list-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';	
							
							$return .= '<button data-group="tabgroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="tabgroup" class="btn btn-primary btn-xs add-list-item">' . __('Add Tab', 'ut_shortcodes' ) . '</button><div class="clear"></div><br />';
			
			} elseif( $name == 'verticaltabgroup' ) {
				
				$return .= '<p><label>'.__( 'Manage Vertical Image Tabs' , 'ut_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-list-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-lister well-white">';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Title' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<input data-group="tabgroup" class="sc-list-item form-control propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Tab Content' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<textarea data-group="tabgroup" class="sc-list-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';	
							
							$return .= '<button data-group="tabgroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="tabgroup" class="btn btn-primary btn-xs add-list-item">' . __('Add Tab', 'ut_shortcodes' ) . '</button><div class="clear"></div><br />';
					
			} elseif( $name == 'clientgroup' ) {
				
				$return .= '<p><label>'.__( 'Manage Clients' , 'ut_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-client-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-clients well-white">';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Client Name' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<input data-group="clientgroup" class="sc-client-item form-control client-name propertychange" type="text" name="" value="" />';
							$return .= '</div>';
														
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Client URL' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<input data-group="clientgroup" class="sc-client-item form-control client-url propertychange" type="text" name="" value="" />';
							$return .= '</div>';
														
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Logo' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value ut-media-access" style="margin-bottom:10px;">';
									$return .= '<input data-group="clientgroup" class="sc-client-item form-control client-logo propertychange" type="text" value="" />';
									$return .= ut_media_access( __('Add Logo', 'ut_shortcodes' ) );
							$return .= '</div>';
															
							$return .= '<button data-group="clientgroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';							
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="clientgroup" class="btn btn-primary btn-xs add-client-item">'.__('Add Client', 'ut_shortcodes' ).'</button><div class="clear"></div><br />';
			
			} elseif( $name == 'quoterotator' ) {
				
				$return .= '<p><label>'.__( 'Manage Quotes' , 'ut_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-quote-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-quotes well-white">';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Author' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<input data-group="quotegroup" class="sc-quote-item form-control quote-author propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Avatar' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value ut-media-access" style="margin-bottom:10px;">';
									$return .= '<input data-group="quotegroup" class="sc-quote-item form-control quote-avatar propertychange" type="text" value="" />';
									$return .= ut_media_access( __('Add Avatar', 'ut_shortcodes' ) );
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Quote' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<textarea data-group="quotegroup" class="sc-quote-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';
															
							$return .= '<button data-group="quotegroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';
							
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="quotegroup" class="btn btn-primary btn-xs add-quote-item">'.__('Add Quote', 'ut_shortcodes' ).'</button><div class="clear"></div><br />';
			
			} elseif( $name == 'quoterotator_alt' ) {
				
				$return .= '<p><label>'.__( 'Manage Quotes' , 'ut_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-quote-alt-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-quotes-alt well-white">';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Author' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<input data-group="quote-alt-group" class="sc-quote-alt-item form-control quote-alt-author propertychange" type="text" name="" value="" />';
							$return .= '</div>';							
						
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Quote' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<textarea data-group="quote-alt-group" class="sc-quote-alt-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';
															
							$return .= '<button data-group="quote-alt-group" type="button" class="btn btn-danger btn-xs remove-group-alt-item"><i class="fa fa-trash-o"></i></button>';
							
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="quote-alt-group" class="btn btn-primary btn-xs add-quote-alt-item">'.__('Add Quote', 'ut_shortcodes' ).'</button><div class="clear"></div><br />';
			
			} elseif( $name == 'togglegroup' ){ 
				
				$return .= '<p><label>'.__( 'Manage Accordion' , 'ut_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-toggle-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-toggles well-white">';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Title' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<input data-group="togglegroup" class="sc-toggle-item form-control propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
													
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Content' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<textarea data-group="togglegroup" class="sc-toggle-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('State' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
							
							$return .= '<select data-group="togglegroup" class="sc-toggle-state sc-select-live">
											<option value="closed">' . __('closed' , 'ut_shortcodes') . '</option>
											<option value="open">' . __('open' , 'ut_shortcodes') . '</option>
										</select>';
							
							$return .= '</div>';
							
							$return .= '<button data-group="togglegroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="togglegroup" class="btn btn-primary btn-xs add-toggle-item">'.__('Add Accordion', 'ut_shortcodes' ).'</button><div class="clear"></div><br />';        
			
			} elseif( $name == 'socialmedia' ){
			
				$return .= '<p><label>'.__( 'Manage Social Media List' , 'ut_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-toggle-socials" data-name="item" data-type="s">';
						$return .= '<div class="sc-socials well-white">';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Profile Title' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<input data-group="socialgroup" class="sc-social-title form-control propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Link to Profile' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<input data-group="socialgroup" class="sc-social-link form-control propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Icon' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
							
							$return .= '<select data-group="socialgroup" class="sc-social-icon sc-select-live">
											<option value="fa-adn">adn</option>
											<option value="fa-android">android</option>
											<option value="fa-apple">apple</option>
											<option value="fa-bitbucket">bitbucket</option>
											<option value="fa-bitcoin">bitcoin</option>
											<option value="fa-btc">btc</option>
											<option value="fa-css3">css3</option>
											<option value="fa-dribbble">dribbble</option>
											<option value="fa-dropbox">dropbox</option>
											<option value="fa-facebook">facebook</option>
											<option value="fa-flickr">flickr</option>
											<option value="fa-foursquare">foursquare</option>
											<option value="fa-github">github</option>
											<option value="fa-gittip">gittip</option>
											<option value="fa-google-plus">google-plus</option>
											<option value="fa-html5">html5</option>
											<option value="fa-instagram">instagram</option>
											<option value="fa-linkedin">linkedin</option>
											<option value="fa-linux">linux</option>
											<option value="fa-maxcdn">maxcdn</option>
											<option value="fa-pinterest">pinterest</option>
											<option value="fa-renren">renren</option>
											<option value="fa-skype">skype</option>
											<option value="fa-stack-exchange">stackexchange</option>
											<option value="fa-trello">trello</option>
											<option value="fa-tumblr">tumblr</option>
											<option value="fa-twitter">twitter</option>
											<option value="fa-vk">vk</option>
											<option value="fa-weibo">weibo</option>
											<option value="fa-windows">windows</option>
											<option value="fa-xing">xing</option>
											<option value="fa-youtube">youtube</option>
										</select>';
							
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
													
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>' . __('Content' , 'ut_shortcodes') . ': </label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<textarea data-group="socialgroup" class="sc-social-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';
							
							$return .= '<button data-group="socialgroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="togglegroup" class="btn btn-primary btn-xs add-social-item">'.__('Add Profile', 'ut_shortcodes' ).'</button><div class="clear"></div>';
			
			
			} elseif( $name == 'probars' ){
				
				$return .= '<label>'.__( 'Manage Bars' , 'ut_shortcodes' ).'</label>';
				
					$return .= '<div class="sc-bar-items" data-name="item" data-type="s">';
					   
					   $return .= '<div class="sc-bars">';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>'.__('Width' , 'ut_shortcodes').'</label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<input data-group="probars" class="sc-bar-width form-control propertychange" type="text" name="" value="" maxlength="3" />';
							$return .= '</div>';
							
							$return  .= '<div class="ut-option-field">';
								$return .= '<label>'.__('Bar Text' , 'ut_shortcodes').'</label>';
							$return .= '</div>';
							
							$return .= '<div class="ut-option-value">';
								$return .= '<input data-group="probars" class="sc-bar-text form-control propertychange" type="text" name="" value="" />';
							$return .= '</div>';
														
							$return .= '<button type="button" data-group="probars" class="btn btn-danger btn-xs remove-bar-item"><i class="fa fa-trash-o"></i></button>';
							
					   $return .= '</div>';
					   
					   $return .= '<div class="sc-bars sc-to-copy">';
							
							$return .= '<p><label>'.__('Width' , 'ut_shortcodes').'</label>';
							$return .= '<input data-group="probars" class="sc-bar-width" type="text" name="" value="" maxlength="3" /></p>';
							
							$return .= '<p><label>'.__('Bar Text' , 'ut_shortcodes').'</label>';
							$return .= '<input data-group="probars" class="sc-bar-text" type="text" name="" value="" /></p>';
							
							$return .= '<button type="button" data-group="probars" class="btn btn-danger btn-xs remove-bar-item"><i class="fa fa-trash-o"></i></button>';
							
					   $return .= '</div>';  
										
					   $return .= '<a href="#" data-group="probars" class="btn add-bar-item">'.__('Add Bar to Group', 'ut_shortcodes' ).'</a>';
					   
					$return .= '</div>';
				
			} elseif( $type == 'c' ){
			
				$return .= '<p><label for="'.$code.'-lastcolumn"><input type="checkbox" class="lastcolumn" id="'.$code.'-lastcolumn" /> '.__('last column' , 'ut_shortcodes').'</label></p>';
			
			} elseif( $name == 'customname' ){
			
				$return .= '<input type="text" id="custom-box-name" class="form-control">';
				
			}
			break;
		
		case 'colorpicker':
			
			$attr_opt['def'] = (isset($attr_opt['def']) && !empty($attr_opt['def'])) ? $attr_opt['def'] : '';
			
			$return .= '<div class="ut-option-field"><label for="sc-opt-'.$name.'">'.$attr_opt['title'].': </label></div>';
			$return .= '<div class="ut-option-value"><input class="attr color-picker-hex form-control ut-color-picker" type="text" data-attrname="'.$name.'" value="'.$attr_opt['def'].'" /></div>';
			
			break;
		
		case 'icon':
			
			$attr_opt['def'] = (isset($attr_opt['def']) && !empty($attr_opt['def'])) ? $attr_opt['def'] : '';
			
			$return .= '<div class="ut-option-field"><label for="sc-opt-'.$name.'">'.$attr_opt['title'].': </label></div>';
			$return .= '<div class="ut-option-value">';
				$return .= '<input style="margin-bottom:10px !important;" class="attr form-control" type="text" data-attrname="'.$name.'" value="'.$attr_opt['def'].'" />';
				$return .= '<a href="#" class="btn btn-primary btn-sm open-ut-modal"> ' . __('Choose Icon' , 'ut_shortcodes') . '</a>';
			$return .= '</div>';
			
			break;
		
		case 'range':
			
			$attr_opt['def'] = (isset($attr_opt['def']) && !empty($attr_opt['def'])) ? $attr_opt['def'] : '';
			
			$return .= '<div class="ut-option-field"><label for="sc-opt-'.$name.'">'.$attr_opt['title'].': </label></div>';
			$return .= '<div class="ut-option-value ut-range-slider-group ut-jquery-ui">';
				$return .= '<div class="ut-range-slider"></div>';
				$return .= '<span class="ut-range-value">0.8</span>';
				$return .= '<input class="attr form-control ut-hidden-range-input" type="text" data-attrname="'.$name.'" value="'.$attr_opt['def'].'" />';
			$return .= '</div>';
			
			break;
			
		
		case 'mediaacess':
			
			$attr_opt['def'] = (isset($attr_opt['def']) && !empty($attr_opt['def'])) ? $attr_opt['def'] : '';
			
			$return .= '<div class="ut-option-field">';
				$return .= '<label for="sc-opt-'.$name.'">'.$attr_opt['title'].': </label><br />';
			$return .= '</div>';	
			
            $return .= '<div class="ut-option-value ut-media-access">';
                
                $return .= '<input class="attr form-control" type="text" data-attrname="'.$name.'" value="'.$attr_opt['def'].'" />';
                $return .= ut_media_access( $attr_opt['title'] );

            $return .= '</div>';
			
			break;
		
		default:
			
			$attr_opt['def'] = (isset($attr_opt['def']) && !empty($attr_opt['def'])) ? $attr_opt['def'] : '';
			
			$return  = '<div class="ut-option-field">';
				$return .= '<label for="sc-opt-'.$name.'">'.$attr_opt['title'].': </label>';
			$return .= '</div>';
			
			$return .= '<div class="ut-option-value">';
			
				$return .= '<input class="attr form-control" type="text" data-attrname="'.$name.'" value="'.$attr_opt['def'].'" />';
				
				if( isset($attr_opt['desc']) && !empty($attr_opt['desc']) ) {
					$return .= '<span class="description">'.$attr_opt['desc'].'</span>';
				}
			
			$return .= '</div>';
			
			break;
			
		}
		
		$return .= '<div class="hr"></div>';
		
		return $return;
		
	}

}


/*
|--------------------------------------------------------------------------
| generate shortcode radio option field
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_generate_radio_option' ) ) {

	function ut_generate_radio_option( $name, $attr_opt, $type, $code ) {
		
		$return  = '<div class="ut-option-field">';
			$return  .= $attr_opt['title'] . ':';
		$return .= '</div>';
		
		$return .= '<div class="ut-option-value">';
			
			$return .= '<div class="btn-group" data-toggle="buttons">';
			
			foreach( $attr_opt['opt'] as $val => $title ){
				
				$return .= '<label for="sc-opt-'.$code.'-'.$name.'-'.$val.'" data-value="'.$val.'" class="btn btn-primary '.($val==$attr_opt['def']?'active':'').'">';
				$return .= '<input class="attr" type="radio" data-attrname="'.$name.'" name="'.$code.'-'.$name.'" value="'.$val.'" id="sc-opt-'.$code.'-'.$name.'-'.$val.'"'.($val==$attr_opt['def']?' checked="checked"':'').'>';
				$return .= $title;
				$return .= '</label>';						
			}
			
			$return .= '</div>';
			
			if( isset($attr_opt['desc']) && !empty($attr_opt['desc']) ) {
			
				$return .= '<span class="description">'.$attr_opt['desc'].'</span>';
			
			}
			
		$return .= '</div>';
		$return .= '<div class="hr"></div>';
		
		return $return;
		
	}
	
}


/*
|--------------------------------------------------------------------------
| generate shortcode select option field
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_generate_select_option' ) ) {

	function ut_generate_select_option( $name, $attr_opt, $type, $code ) {
		
		/* values */
		$values = $attr_opt['values'];
		
		/* start output */
		$return  = '<div class="ut-option-field">';
			$return .= '<label for="'.$name.'">' . $attr_opt['title'] . ': </label>';
		$return .= '</div>';
			
		$return .= '<div class="ut-option-value">';
		$return .= '<select data-attrname="'.$name.'" class="form-control sc-select-control" id="'.$name.'">';
		
			$return .= '<option value="">' . __( 'Choose' , 'ut_shortcodes' ) . ' '  . $attr_opt['title'] . '</option>';
			
			foreach( $values as $value ){
				
				$return .= '<option value="'.$value.'">'.$value.'</option>';
				
			}
			
			$return .= '</select>';
			
			if( isset($attr_opt['desc']) && !empty($attr_opt['desc']) ) {
			
				$return .= '<span class="description">'.$attr_opt['desc'].'</span>';
			
			} else {
			
				$return .= '';
				
			}
		
		$return .= '</div>';
		$return .= '<div class="hr"></div>';
			
		return $return;
		
	}
	
}

/*
|--------------------------------------------------------------------------
| Media Access Button
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_media_access' ) ) {

	function ut_media_access($button_text = "Insert", $uploader_title = "Site Files", $uploader_button = "Insert", $uploader_type = ""){
		
		$button = sprintf('<a href="#" class="ut-upload-button btn btn-primary btn-sm" data-uploader_title="%s" data-uploader_button_text="%s" data-limit_type="%s"><i class="fa fa-picture fa-inverse"></i> %s</a>', $uploader_title, $uploader_button, $uploader_type, $button_text);
		return $button;
	
	}
	
}

/*
|--------------------------------------------------------------------------
| generate shortcode select field
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_generate_sc_select' ) ) {
	
	function ut_generate_sc_select() {
		
		global $ut_shortcodes;
		
		$counter = 1;
		$select  = '<p><select id="ut-shortcodes" class="form-control">';
		$select .= '<option selected="selected" value="" disabled="disabled">'.__('Choose Shortcode' , 'ut_shortcodes').'</option>';
		
		foreach( $ut_shortcodes as $code => $options ){
			
			/* definition is a headline */
			if($code == 'headline_'.$counter) {
				
				$select .= '<option class="disabled" value="'.$options['title'].'" disabled="disabled">'.$options['title'].'</option>';
				$counter++;
			
			/* definition is a shortcode */	
			} else {
				
				$options['clabel'] = (isset($options['clabel']) && !empty($options['clabel'])) ? $options['clabel'] : '';
				$select .= '<option value="'.$code.'" data-clabel="'.$options['clabel'].'">'.$options['title'].'</option>';
				
			}
			
		}
		
		$select .= '</select></p>';
		
		return $select;
		
	}
	
}


/*
|--------------------------------------------------------------------------
| generate shortcode boxes
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_generate_sc_box' ) ) {
	
	function ut_generate_sc_box() {
		
		global $ut_shortcodes;
		
		$boxes   = '';
		$counter = 1;
		
		$boxes .= '<h4 class="sc-settings">'.__('Shortcode Settings:' , 'ut_shortcodes').'</h4>';

		foreach( $ut_shortcodes as $code => $options ){
			
			if( $code == 'headline_'.$counter ) {
				
				$counter++;
			
			} else {
			
			$boxes .= '<div class="sc-options well" id="options-'.$code.'" data-name="'.$code.'" data-type="'.$options['type'].'">';
						
				if( isset($options['attr']) ){
																			  
					 foreach( $options['attr'] as $name => $attr_opt ){
						$boxes .= ut_get_option_element( $name, $attr_opt, $options['type'], $code );
					 }
					 
				}
			
			$boxes .= '</div>';
			
			}
				
		}
				
		return $boxes;
		
	}
	
} ?>