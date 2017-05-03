<?php

abstract class HyunmooString
{
	/**
	 * Increment styles.
	 *
	 * @var    array
	 * @since  11.3
	 */
	protected static $incrementStyles = array(
		'dash' => array(
			'#-(\d+)$#',
			'-%d'
		),
		'default' => array(
			array('#\((\d+)\)$#', '#\(\d+\)$#'),
			array(' (%d)', '(%d)'),
		),
	);

	/**
	 * Split a string in camel case format
	 *
	 * "FooBarABCDef"            becomes  array("Foo", "Bar", "ABC", "Def");
	 * "JFooBar"                 becomes  array("J", "Foo", "Bar");
	 * "J001FooBar002"           becomes  array("J001", "Foo", "Bar002");
	 * "abcDef"                  becomes  array("abc", "Def");
	 * "abc_defGhi_Jkl"          becomes  array("abc_def", "Ghi_Jkl");
	 * "ThisIsA_NASAAstronaut"   becomes  array("This", "Is", "A_NASA", "Astronaut")),
	 * "JohnFitzgerald_Kennedy"  becomes  array("John", "Fitzgerald_Kennedy")),
	 *
	 * @param   string  $string  The source string.
	 *
	 * @return  array   The splitted string.
	 *
	 * @since   11.3
	 */
	public static function splitCamelCase($string)
	{
		return preg_split('/(?<=[^A-Z_])(?=[A-Z])|(?<=[A-Z])(?=[A-Z][^A-Z_])/x', $string);
	}

	/**
	 * Increments a trailing number in a string.
	 *
	 * Used to easily create distinct labels when copying objects. The method has the following styles:
	 *
	 * default: "Label" becomes "Label (2)"
	 * dash:    "Label" becomes "Label-2"
	 *
	 * @param   string   $string  The source string.
	 * @param   string   $style   The the style (default|dash).
	 * @param   integer  $n       If supplied, this number is used for the copy, otherwise it is the 'next' number.
	 *
	 * @return  string  The incremented string.
	 *
	 * @since   11.3
	 */
	public static function increment($string, $style = 'default', $n = 0)
	{
		$styleSpec = isset(self::$incrementStyles[$style]) ? self::$incrementStyles[$style] : self::$incrementStyles['default'];

		// Regular expression search and replace patterns.
		if (is_array($styleSpec[0]))
		{
			$rxSearch = $styleSpec[0][0];
			$rxReplace = $styleSpec[0][1];
		}
		else
		{
			$rxSearch = $rxReplace = $styleSpec[0];
		}

		// New and old (existing) sprintf formats.
		if (is_array($styleSpec[1]))
		{
			$newFormat = $styleSpec[1][0];
			$oldFormat = $styleSpec[1][1];
		}
		else
		{
			$newFormat = $oldFormat = $styleSpec[1];
		}

		// Check if we are incrementing an existing pattern, or appending a new one.
		if (preg_match($rxSearch, $string, $matches))
		{
			$n = empty($n) ? ($matches[1] + 1) : $n;
			$string = preg_replace($rxReplace, sprintf($oldFormat, $n), $string);
		}
		else
		{
			$n = empty($n) ? 2 : $n;
			$string .= sprintf($newFormat, $n);
		}

		return $string;
	}


	/**
	 * Catch an error and throw an exception.
	 *
	 * @param   integer  $number   Error level
	 * @param   string   $message  Error message
	 *
	 * @return  void
	 *
	 * @link    https://bugs.php.net/bug.php?id=48147
	 *
	 * @throw   ErrorException
	 */
	private static function _iconvErrorHandler($number, $message)
	{
		throw new ErrorException($message, 0, $number);
	}

	/**
	 * Transcode a string.
	 *
	 * @param   string  $source         The string to transcode.
	 * @param   string  $from_encoding  The source encoding.
	 * @param   string  $to_encoding    The target encoding.
	 *
	 * @return  mixed  The transcoded string, or null if the source was not a string.
	 *
	 * @link    https://bugs.php.net/bug.php?id=48147
	 *
	 * @since   11.1
	 */
	public static function transcode($source, $from_encoding, $to_encoding)
	{
		if (is_string($source))
		{
			set_error_handler(array(__CLASS__, '_iconvErrorHandler'), E_NOTICE);
			try
			{
				/*
				 * "//TRANSLIT//IGNORE" is appended to the $to_encoding to ensure that when iconv comes
				 * across a character that cannot be represented in the target charset, it can
				 * be approximated through one or several similarly looking characters or ignored.
				 */
				$iconv = iconv($from_encoding, $to_encoding . '//TRANSLIT//IGNORE', $source);
			}
			catch (ErrorException $e)
			{
				/*
				 * "//IGNORE" is appended to the $to_encoding to ensure that when iconv comes
				 * across a character that cannot be represented in the target charset, it is ignored.
				 */
				$iconv = iconv($from_encoding, $to_encoding . '//IGNORE', $source);
			}
			restore_error_handler();
			return $iconv;
		}

		return null;
	}

	/**
	 * Tests a string as to whether it's valid UTF-8 and supported by the Unicode standard.
	 *
	 * Note: this function has been modified to simple return true or false.
	 *
	 * @param   string  $str  UTF-8 encoded string.
	 *
	 * @return  boolean  true if valid
	 *
	 * @author  <hsivonen@iki.fi>
	 * @see     http://hsivonen.iki.fi/php-utf8/
	 * @see     compliant
	 * @since   11.1
	 */
	public static function valid($str)
	{
		// Cached expected number of octets after the current octet
		// until the beginning of the next UTF8 character sequence
		$mState = 0;

		// Cached Unicode character
		$mUcs4 = 0;

		// Cached expected number of octets in the current sequence
		$mBytes = 1;

		$len = strlen($str);

		for ($i = 0; $i < $len; $i++)
		{
			$in = ord($str{$i});

			if ($mState == 0)
			{
				// When mState is zero we expect either a US-ASCII character or a
				// multi-octet sequence.
				if (0 == (0x80 & ($in)))
				{
					// US-ASCII, pass straight through.
					$mBytes = 1;
				}
				elseif (0xC0 == (0xE0 & ($in)))
				{
					// First octet of 2 octet sequence
					$mUcs4 = ($in);
					$mUcs4 = ($mUcs4 & 0x1F) << 6;
					$mState = 1;
					$mBytes = 2;
				}
				elseif (0xE0 == (0xF0 & ($in)))
				{
					// First octet of 3 octet sequence
					$mUcs4 = ($in);
					$mUcs4 = ($mUcs4 & 0x0F) << 12;
					$mState = 2;
					$mBytes = 3;
				}
				elseif (0xF0 == (0xF8 & ($in)))
				{
					// First octet of 4 octet sequence
					$mUcs4 = ($in);
					$mUcs4 = ($mUcs4 & 0x07) << 18;
					$mState = 3;
					$mBytes = 4;
				}
				elseif (0xF8 == (0xFC & ($in)))
				{
					/* First octet of 5 octet sequence.
					 *
					 * This is illegal because the encoded codepoint must be either
					 * (a) not the shortest form or
					 * (b) outside the Unicode range of 0-0x10FFFF.
					 * Rather than trying to resynchronize, we will carry on until the end
					 * of the sequence and let the later error handling code catch it.
					 */
					$mUcs4 = ($in);
					$mUcs4 = ($mUcs4 & 0x03) << 24;
					$mState = 4;
					$mBytes = 5;
				}
				elseif (0xFC == (0xFE & ($in)))
				{
					// First octet of 6 octet sequence, see comments for 5 octet sequence.
					$mUcs4 = ($in);
					$mUcs4 = ($mUcs4 & 1) << 30;
					$mState = 5;
					$mBytes = 6;

				}
				else
				{
					/* Current octet is neither in the US-ASCII range nor a legal first
					 * octet of a multi-octet sequence.
					 */
					return false;
				}
			}
			else
			{
				// When mState is non-zero, we expect a continuation of the multi-octet
				// sequence
				if (0x80 == (0xC0 & ($in)))
				{
					// Legal continuation.
					$shift = ($mState - 1) * 6;
					$tmp = $in;
					$tmp = ($tmp & 0x0000003F) << $shift;
					$mUcs4 |= $tmp;

					/**
					 * End of the multi-octet sequence. mUcs4 now contains the final
					 * Unicode codepoint to be output
					 */
					if (0 == --$mState)
					{
						/*
						 * Check for illegal sequences and codepoints.
						 */
						// From Unicode 3.1, non-shortest form is illegal
						if (((2 == $mBytes) && ($mUcs4 < 0x0080)) || ((3 == $mBytes) && ($mUcs4 < 0x0800)) || ((4 == $mBytes) && ($mUcs4 < 0x10000))
							|| (4 < $mBytes)
							|| (($mUcs4 & 0xFFFFF800) == 0xD800) // From Unicode 3.2, surrogate characters are illegal
							|| ($mUcs4 > 0x10FFFF)) // Codepoints outside the Unicode range are illegal
						{
							return false;
						}

						// Initialize UTF8 cache.
						$mState = 0;
						$mUcs4 = 0;
						$mBytes = 1;
					}
				}
				else
				{
					/**
					 *((0xC0 & (*in) != 0x80) && (mState != 0))
					 * Incomplete multi-octet sequence.
					 */
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Tests whether a string complies as UTF-8. This will be much
	 * faster than utf8_is_valid but will pass five and six octet
	 * UTF-8 sequences, which are not supported by Unicode and
	 * so cannot be displayed correctly in a browser. In other words
	 * it is not as strict as utf8_is_valid but it's faster. If you use
	 * it to validate user input, you place yourself at the risk that
	 * attackers will be able to inject 5 and 6 byte sequences (which
	 * may or may not be a significant risk, depending on what you are
	 * are doing)
	 *
	 * @param   string  $str  UTF-8 string to check
	 *
	 * @return  boolean  TRUE if string is valid UTF-8
	 *
	 * @see     valid
	 * @see     http://www.php.net/manual/en/reference.pcre.pattern.modifiers.php#54805
	 * @since   11.1
	 */
	public static function compliant($str)
	{
		if (strlen($str) == 0)
		{
			return true;
		}
		// If even just the first character can be matched, when the /u
		// modifier is used, then it's valid UTF-8. If the UTF-8 is somehow
		// invalid, nothing at all will match, even if the string contains
		// some valid sequences
		return (preg_match('/^.{1}/us', $str, $ar) == 1);
	}

	/**
	 * Does a UTF-8 safe version of PHP parse_url function
	 *
	 * @param   string  $url  URL to parse
	 *
	 * @return  mixed  Associative array or false if badly formed URL.
	 *
	 * @see     http://us3.php.net/manual/en/function.parse-url.php
	 * @since   11.1
	 */
	public static function parse_url($url)
	{
		$result = array();
		// Build arrays of values we need to decode before parsing
		$entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B',
			'%5D');
		$replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "$", ",", "/", "?", "%", "#", "[", "]");
		// Create encoded URL with special URL characters decoded so it can be parsed
		// All other characters will be encoded
		$encodedURL = str_replace($entities, $replacements, urlencode($url));
		// Parse the encoded URL
		$encodedParts = parse_url($encodedURL);
		// Now, decode each value of the resulting array
		foreach ($encodedParts as $key => $value)
		{
			$result[$key] = urldecode($value);
		}
		return $result;
	}
	/**
	 * Method to convert a string into camel case.
	 *
	 * @param   string  $input  The string input.
	 *
	 * @return  string  The camel case string.
	 *
	 * @since   11.3
	 */
	public static function toCamelCase($input)
	{
		// Convert words to uppercase and then remove spaces.
		$input = self::toSpaceSeparated($input);
		$input = ucwords($input);
		$input = str_ireplace(' ', '', $input);

		return $input;
	}

	/**
	 * Method to convert a string into dash separated form.
	 *
	 * @param   string  $input  The string input.
	 *
	 * @return  string  The dash separated string.
	 *
	 * @since   11.3
	 */
	public static function toDashSeparated($input)
	{
		// Convert spaces and underscores to dashes.
		$input = str_ireplace(array(' ', '_'), '-', $input);

		// Remove duplicate dashes.
		$input = preg_replace('#-+#', '-', $input);

		return $input;
	}

	/**
	 * Method to convert a string into space separated form.
	 *
	 * @param   string  $input  The string input.
	 *
	 * @return  string  The space separated string.
	 *
	 * @since   11.3
	 */
	public static function toSpaceSeparated($input)
	{
		// Convert underscores and dashes to spaces.
		$input = str_ireplace(array('_', '-'), ' ', $input);

		// Remove duplicate spaces.
		$input = preg_replace('#\s+#', ' ', $input);

		return $input;
	}

	/**
	 * Method to convert a string into underscore separated form.
	 *
	 * @param   string  $input  The string input.
	 *
	 * @return  string  The underscore separated string.
	 *
	 * @since   11.3
	 */
	public static function toUnderscoreSeparated($input)
	{
		// Convert spaces and dashes to underscores.
		$input = str_ireplace(array(' ', '-'), '_', $input);

		// Remove duplicate underscores.
		$input = preg_replace('#_+#', '_', $input);

		return $input;
	}

	/**
	 * Method to convert a string into variable form.
	 *
	 * @param   string  $input  The string input.
	 *
	 * @return  string  The variable string.
	 *
	 * @since   11.3
	 */
	public static function toVariable($input)
	{
		// Remove dashes and underscores, then convert to camel case.
		$input = self::toSpaceSeparated($input);
		$input = self::toCamelCase($input);

		// Remove leading digits.
		$input = preg_replace('#^[0-9]+.*$#', '', $input);

		// Lowercase the first character.
		$first = substr($input, 0, 1);
		$first = strtolower($first);

		// Replace the first character with the lowercase character.
		$input = substr_replace($input, $first, 0, 1);

		return $input;
	}

	/**
	 * Method to convert a string into key form.
	 *
	 * @param   string  $input  The string input.
	 *
	 * @return  string  The key string.
	 *
	 * @since   11.3
	 */
	public static function toKey($input)
	{
		// Remove spaces and dashes, then convert to lower case.
		$input = self::toUnderscoreSeparated($input);
		$input = strtolower($input);

		return $input;
	}
	
	/**
	 * Method to sanitize a string.
	 *
	 * Returns a string with A-Z and a-z characters.
	 *
	 * @return string sanitized.
	 */
	public static function sanitize( $input )
	{
		$input = strtolower( preg_replace( '/[^A-Za-z]/', '', $input ) );
		return $input;
	}
}
