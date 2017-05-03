<?php

abstract class Encryption {
	public static $key = '';
	
	public static function encrypt( $text ) {
		$key = self::getKey();
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
		return $crypttext;
	}
	public static function decrypt( $crypttext ) {
		$key = self::getKey();
	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv);
	    return trim($decrypttext);
	}
	public static function getKey() {
		if( !self::$key ) {
			self::$key = get_option( 'hyunmoo_key' );
		}
		return self::$key;
	}
}
?>