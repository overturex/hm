<?php
/*
 * Plugin Name: Portfolio Management by UnitedThemes
 * Version: 1.4
 * Plugin URI: http://www.unitedthemes.com/
 * Description: Easily present your works to the crowd
 * Author: UnitedThemes 
 * Author URI: http://www.unitedthemes.com/
 * Requires at least: 3.4
 * Tested up to: 3.8
 * 
 * @package WordPress
 * @author United Themes
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;


/*
|--------------------------------------------------------------------------
| Basic Constants 
|--------------------------------------------------------------------------
*/

define( 'UT_PORTFOLIO_DIR' , plugin_dir_path(__FILE__));
define( 'UT_PORTFOLIO_URL' , plugin_dir_url(__FILE__));
define( 'UT_PORTFOLIO_ASSETS_URL' , UT_PORTFOLIO_URL . 'assets/');
define( 'UT_PORTFOLIO_VERSION' , '1.4');

/* to do - make variable*/
define( 'UT_PORTFOLIO_ITEM' , 'portfolio-item'); 


/*
|--------------------------------------------------------------------------
| FILTERS
|--------------------------------------------------------------------------
*/

add_filter( 'template_include', 'ut_template_chooser');


/*
|--------------------------------------------------------------------------
| load main style
|--------------------------------------------------------------------------
*/

if( !function_exists('ut_portfolio_enqueuestyles') ) :

	function ut_portfolio_enqueuestyles() {
		
		$ut_portfolio = file_exists( get_stylesheet_directory() . '/css/ut.portfolio.style.css' ) ? get_stylesheet_directory_uri() . '/css/ut.portfolio.style.css' : UT_PORTFOLIO_ASSETS_URL . '/css/ut.portfolio.style.css';
				
		if( !is_admin() ) {
			
			wp_enqueue_style( 'ut-portfolio' , $ut_portfolio , array('ut-flexslider') );
			wp_enqueue_style( 'ut-prettyphoto',	UT_PORTFOLIO_URL . '/assets/css/plugins/prettyphoto/prettyPhoto.css' );
			
		}
		
	}
	
	add_action('get_header', 'ut_portfolio_enqueuestyles');

endif;

if( !function_exists('ut_portfolio_enqueuescripts') ) :

	function ut_portfolio_enqueuescripts() {
		
		if( !is_admin() ) {
			
			wp_enqueue_script('ut-scrollTo'		, UT_PORTFOLIO_URL . 'assets/js/jquery.scrollTo.min.js', array('jquery'), '1.4.6' , true );
			wp_enqueue_script('ut-isotope-js' 	, UT_PORTFOLIO_URL . 'assets/js/jquery.isotope.min.js' , array('jquery'), '1.8' , false);
			wp_enqueue_script('ut-isotope-js' 	, UT_PORTFOLIO_URL . 'assets/js/jquery.isotope.min.js' , array('jquery'), '1.8' , false);      
			wp_enqueue_script('ut-prettyphoto'  , UT_PORTFOLIO_URL . 'assets/js/plugins/prettyphoto/jquery.prettyPhoto.min.js', array('jquery'), '3.1.5' , true );
			
		}
		
	}
	add_action('wp_enqueue_scripts', 'ut_portfolio_enqueuescripts');

endif;

/*
|--------------------------------------------------------------------------
| Include plugin class files
|--------------------------------------------------------------------------
*/

/* settings */
require_once( 'classes/class-ut-portfolio-template.php' );

/* post types */
require_once( 'classes/post-types/class-portfolio.php' );
require_once( 'classes/post-types/class-portfolio-manager.php' );

/* image resizer */
require_once( 'inc/ut-image-resize.php' );

/* shortcode */
require_once( 'classes/class-ut-portfolio-shortcode.php' ); 


/*
|--------------------------------------------------------------------------
| Instantiate necessary classes
|--------------------------------------------------------------------------
*/

global $ut_portfolio_obj;

$ut_portfolio_obj = new UT_Portfolio_Template( __FILE__ );
$ut_portfolio_type_obj = new UT_Portfolio( __FILE__ );
$ut_portfolio_manager_obj = new UT_Portfolio_Manager( __FILE__ );

/* for future updates */
//require_once( 'classes/class-ut-portfolio-settings.php' );
//$ut_portfolio_settings_obj = new UT_Portfolio_Settings( __FILE__ );

/*
|--------------------------------------------------------------------------
| Returns template file
|--------------------------------------------------------------------------
*/

if ( ! function_exists( 'ut_template_chooser' ) ) :

	function ut_template_chooser($template) {
		
		global $post;
		
		if( is_object( $post ) ) {
			$post_id = get_the_ID();
		} else {
			return $template;
		}
		
		// For all other CPT
		if( get_post_type( $post_id ) != 'portfolio' ) {
			return $template;
		}
		
		// Else use custom template
		if ( is_single() ) {
			return ut_get_template_hierarchy('single-portfolio');
		}
	
	}

endif;


/*
|--------------------------------------------------------------------------
| Get the custom template if is set
|--------------------------------------------------------------------------
*/
function ut_get_template_hierarchy( $template ) {

    // Get the template slug
    $template_slug = rtrim($template, '.php');
    $template      = $template_slug . '.php';
    
    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    if ( $theme_file = locate_template(array($template)) ) {
    	$file = $theme_file;
    }
    else {
    	$file = UT_PORTFOLIO_DIR . '/templates/' . $template;
    }
    
    return apply_filters( 'ut_repl_template_'.$template, $file);
}
?>