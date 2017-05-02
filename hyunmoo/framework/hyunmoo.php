<?php

abstract class Hyunmoo
{
	static $config = false;
	static $theme_admin = false;
	static $theme_site = false;
	static $helpers = array();
	
	public static function runAuth() {
		require_once( dirname( __FILE__ ) . DS . 'theme' . DS . 'auth.php' );
		new HyunmooAuth();
	}
	public static function getConfig( $name, $context = false ) {
		global $hyunmoo;
		require_once( $hyunmoo['kernel'] . DS . 'config.php' );
		if( self::$config === false )
			self::$config = new HyunmooConfig;
		return self::$config->getConfig( $name, $context );
	}
	public static function setConfig( $name, $options, $context = false ) {
		global $hyunmoo;
		require_once( $hyunmoo['kernel'] . DS . 'config.php' );
		if( self::$config === false )
			self::$config = new HyunmooConfig;
		return self::$config->setConfig( $name, $options, $context );
	}
	public static function deleteConfig( $name, $context = false ) {
		global $hyunmoo;
		require_once( $hyunmoo['kernel'] . DS . 'config.php' );
		if( self::$config === false )
			self::$config = new HyunmooConfig;
		return self::$config->deleteConfig( $name, $context );
	}
	public static function getTheme() {
		if( is_admin() ) {
			if( self::$theme_admin )
				return self::$theme_admin;
			else {
				require_once( dirname( __FILE__ ) . DS . 'theme' . DS . 'admin.php' );
				self::$theme_admin = & new HyunmooAdmin();
				return self::$theme_admin;
			}
		}
		else {
			if( self::$theme_site )
				return self::$theme_site;
			else {
				require_once( dirname( __FILE__ ) . DS . 'theme' . DS . 'site.php' );
				self::$theme_site = & new HyunmooSite();
				return self::$theme_site;
			}
		}
	}
	public static function getHelper( $name ) {
		global $hyunmoo;
		require_once( $hyunmoo['kernel'] . DS . 'string.php' );
		$name = strtolower( HyunmooString::sanitize( $name ) );
		
		if( isset( self::$helpers[$name] ) )
			return self::$helpers[$name];
			
		require_once( $hyunmoo['helpers'] . DS . $name . '.php' );
		$class = 'HyunmooHelper' . ucfirst( $name );
		$helper = new $class;
		self::$helpers[$name] = & $helper;
		return self::$helpers[$name];
	}
	
	private function __clone() {}
}
?>