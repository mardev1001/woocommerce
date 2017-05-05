<?php

class HyunmooSite {

	protected $template;
	protected $default_tpl = 'baby';
	protected $styles = array();
	protected $scripts = array();
	protected $detect = false;
	
	public function __construct() {
		$config = Hyunmoo::getConfig( 'settings.basic' );
		$this->template = isset( $config['site_tpl'] ) ? $config['site_tpl'] : $this->default_tpl;
	}
	public function initialize() {
		require_once get_template_directory() . DS . 'library' . DS . 'Mobile_Detect.php';
		require_once get_template_directory() . DS . 'includes' . DS . 'hooks.php';
		require_once get_template_directory() . DS . 'includes' . DS . 'functions.php';
		
		//Set Template for individual device
		if( !$this->detect )
			$this->detect = new Mobile_Detect;
		$config = Hyunmoo::getConfig( 'settings.basic' );
		$mobile_check = ( in_array( 'yes', (array) $config['mobile_tpl'] ) ) ? true : false;
		
		if( $this->detect->isMobile() ) {
			$device = 'mobile';
			if( $this->detect->isTablet() )
				$device = 'tablet';
		}
		if( $mobile_check == true && $device == 'mobile' )
			$this->template = 'mobile';
		elseif( $device == 'tablet' )
			$this->template = 'tablet';
		else
			$this->template = $this->default_tpl;
			
		$config = Hyunmoo::getConfig( 'settings.advanced' );
		$debug = ( in_array( 'yes', (array) $config['tpl_debug'] ) ) ? true : false;
		if( $debug == true ) {
			$tpl = isset( $_GET['tpl'] ) ? $_GET['tpl'] : $this->template;
			$this->template = $tpl;
		}
	}
	
	public function getTemplate() {
		return $this->template;
	}
	//Additional styles/scripts for frontend --- Can be used in plugins
	public function print_styles() {
		if( empty( $this->styles ) )
			return;
		
		foreach( $this->styles as $handle => $url ) {
			wp_register_style( $handle, $url );
			wp_enqueue_style( $handle );
		}
	}
	public function print_scripts() {
		if( empty( $this->scripts ) )
			return;
		
		foreach( $this->scripts as $handle => $option ) {
			wp_enqueue_script( $handle, $option['url'], array(), false, $option['footer'] );
		}
	}
	public function enqueue_style( $handle, $url = false ) {
		if( trim( $handle ) == '' )
			return;
			
		$this->styles[$handle] = esc_url( $url );
	}
	public function enqueue_script( $handle, $url = false, $footer = false ) {
		if( trim( $handle ) == '' )
			return;
		if( $url === false ) {
			wp_enqueue_script( $handle );
			return;
		}
		$option = array(
			'url'		=> esc_url( $url ),
			'footer'	=> $footer
		);
		$this->scripts[$handle] = $option;
	}
	
	public function get_template_url( $template = '' ) {
		$template = ( $template == '' ) ? $this->template : $template;
		$url = get_template_directory_uri() . '/templates/' . $template;
		return $url;
	}
	public function template_style( $template = '' ) {
		$template = ( $template == '' ) ? $this->template : $template;
		$style = get_template_directory_uri() . '/templates/' . $template . '/style.css';
		echo $style;
	}

	public function title() {
		if ( is_home() ) { bloginfo( 'name' ); } 
		elseif ( is_category() ) {
			single_cat_title(); echo " - "; bloginfo( 'name' );
		} elseif ( is_single() || is_page() ) {
			single_post_title();
		} elseif( is_search() ) {
			bloginfo( 'name' ); echo " search results: "; echo esc_html( $s );
		} else { wp_title( '', true ); }
	}
	
	public function render( $type, $folder = false ) {
		if( !$type )
			return;
			
		$fallback_path = get_template_directory() . DS . 'templates' . DS . $this->default_tpl;
		$path = get_template_directory() . DS . 'templates' . DS . $this->template;
		if( !$folder ) {
			$fallback_tpl = $fallback_path . DS . $type . '.php';
			$tpl = $path . DS . $type. '.php';
		}
		else {
			$fallback_tpl = $fallback_path . DS . $folder . DS . $type . '.php';
			$tpl = $path . DS . $folder . DS . $type . '.php';
		}
		if( file_exists( $tpl ) )
			require_once( $tpl );
		else
			require_once( $fallback_tpl );
	}
}