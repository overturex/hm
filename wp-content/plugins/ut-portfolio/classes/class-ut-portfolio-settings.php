<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class UT_Portfolio_Settings {
	
    private $dir;
	private $file;
	private $assets_dir;
	private $assets_url;

	public function __construct( $file ) {
		
        $this->dir = dirname( $file );
		$this->file = $file;
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $file ) ) );

		// Register plugin settings
		add_action( 'admin_init' , array( &$this , 'register_settings' ) );

		// Add settings page to menu
		add_action( 'admin_menu' , array( &$this , 'add_menu_item' ) );

		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->file ) , array( &$this , 'add_settings_link' ) );
	}
	
	public function add_menu_item() {
		add_options_page( 'Portfolio Settings' , 'Portfolio Settings' , 'manage_options' , 'portfolio_settings' ,  array( &$this , 'settings_page' ) );
	}

	public function add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=portfolio_settings">Settings</a>';
  		array_push( $links, $settings_link );
  		return $links;
	}

	public function register_settings() {
		
		// Add settings section
		add_settings_section( 'main_settings' , __( 'Modify portfolio settings' , 'ut_portfolio_lang' ) , array( &$this , 'main_settings' ) , 'portfolio_settings' );
		
		// Add settings fields
		add_settings_field( 'portfolio_layout_mode' , __( 'Layout Mode:' , 'ut_portfolio_lang' ) , array( &$this , 'portfolio_layout_mode' )  , 'portfolio_settings' , 'main_settings' );
		
		// Register settings fields
		register_setting( 'portfolio_settings' , 'portfolio_layout_mode' , array( &$this , 'validate_field' ) );

	}

	public function main_settings() { echo '<p>' . __( 'Global Settings.' , 'ut_portfolio_lang' ) . '</p>'; }

	public function portfolio_layout_mode() {

		$option = get_option('portfolio_layout_mode');

		$data = '';
		if( $option && strlen( $option ) > 0 && $option != '' ) {
			$data = $option;
		}
		
		echo '<select class="postform" id="ut_portfolio_layout" name="portfolio_layout_mode">';
			echo '<option value="theme" ' . selected( 'theme' , $data , false ) . '>' . __('Theme CSS' , 'ut_portfolio_lang') . '</option>';
			echo '<option value="default" ' . selected( 'default' , $data , false ) . '>' . __('Default CSS' , 'ut_portfolio_lang') . '</option>';
		echo '</select>';
		
		echo '<p>' . __( 'If you are planing to use the "Theme CSS" please make sure you have placed a copy of the following file inside your theme or childtheme: ' , 'ut_portfolio_lang' );
		echo '<code>wp-content/themes/YOURTHEME/css/ut.portfolio.css </code></p>';
		echo '<p class="description">' . __( 'Themes made by UnitedThemes are already coming with the necessary file, so there is no need to place it in there. ' , 'ut_portfolio_lang' ) . '</p>';

		
	}

	public function validate_field( $slug ) {
		if( $slug && strlen( $slug ) > 0 && $slug != '' ) {
			$slug = urlencode( strtolower( str_replace( ' ' , '-' , $slug ) ) );
		}
		return $slug;
	}

	public function settings_page() {

		echo '<div class="wrap">
				<div class="icon32" id="icon-options-general"><br/></div>
				<h2>' . __('Portfolio Settings' , 'ut_portfolio_lang') . '</h2>
				<form method="post" action="options.php" enctype="multipart/form-data">';

				settings_fields( 'portfolio_settings' );
				do_settings_sections( 'portfolio_settings' );

			  echo '<p class="submit">
						<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings' , 'ut_portfolio_lang' ) ) . '" />
					</p>
				</form>
			  </div>';
	}
	
}