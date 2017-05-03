<?php

require_once( dirname( __FILE__ ) . DS . 'encryption.php' );
class HyunmooConfig {
	private $configs = array();
	
	public function getConfig( $name, $context = false ) {
		global $hyunmoo;
		$file = $hyunmoo['framework'] . DS . 'config' . DS . $name . '.conf';
		if( $context )
			$file = $hyunmoo['framework'] . DS . 'config' . DS . $context . DS . $name . '.conf';
		if( !is_readable( $file ) )
			return false;
		if( isset( $this->configs[$name] ) )
			return $this->configs[$name];
			
		$content = file_get_contents( $file );
		$content = Encryption::decrypt( $content );
		$config = unserialize( $content );
		return $config;
	}
	public function setConfig( $name, $options, $context = false ) {
		global $hyunmoo;
		$this->configs[$name] = $options;
		$file = $hyunmoo['framework'] . DS . 'config' . DS . $name . '.conf';
		if( $context )
			$file = $hyunmoo['framework'] . DS . 'config' . DS . $context . DS . $name . '.conf';
		
		$content = serialize( $options );
		$content = Encryption::encrypt( $content );
		$saved = file_put_contents( $file, $content );
		
		return $saved;
	}
	public function deleteConfig( $name, $context = false ) {
		global $hyunmoo;
		$file = $hyunmoo['framework'] . DS . 'config' . DS . $name . '.conf';
		if( $context )
			$file = $hyunmoo['framework'] . DS . 'config' . DS . $context . DS . $name . '.conf';
		unlink( $file );
		return true;
	}
}
?>