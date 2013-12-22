<?php

namespace Squeeze1_0\Util
{
  /**
   * Input helper functions
   * @since 1.0
   */
  class Input
  {

    /**
     * Attempts to fetch a given key from the _POST superglobal.
     * If no key is given, return entire array.
     * If key doesn't exist, return null
     * @param mixed $var
     * @return string|array|null
     * @access public
     * @static
     * @since 1.0
     */
    public static function post($var = null)
    {
      return self::getFromArray($_POST, $var);
    }

    /**
     * Attempts to fetch a given key from the _COOKIE superglobal.
     * If no key is given, return entire array.
     * If key doesn't exist, return null
     * @param mixed $var
     * @return string|array|null
     * @access public
     * @static
     * @since 1.0
     */
    public static function cookie($var = null)
    {
      return self::getFromArray($_COOKIE, $var);
    }

    /**
     * Attempts to fetch a given key from the _GET superglobal.
     * If no key is given, return entire array.
     * If key doesn't exist, return null
     * @param mixed $var
     * @return string|array|null
     * @access public
     * @static
     * @since 1.0
     */
    public static function get($var = null)
    {
      return self::getFromArray($_GET, $var);
    }

    /**
     * Attempts to fetch a given key from the _SERVER superglobal.
     * If no key is given, return entire array.
     * If key doesn't exist, return null
     * @param mixed $var
     * @return string|array|null
     * @access public
     * @static
     * @since 1.0
     */
    public static function server($var = null)
    {
      return self::getFromArray($_SERVER, $var);
    }

    /**
     * A generic function to fetch a value from an array
     * If no key is given, return entire array.
     * If key doesn't exist, return null
     * @param mixed $var
     * @return string|array|null
     * @access public
     * @static
     * @since 1.0
     */
    public static function getFromArray($arr, $var = null)
    {
      if (is_null($var)) {
        return (!empty($arr)) ? $arr : null;
      }

      return (isset($arr[$var])) ? $arr[$var] : null;
    }
  }
}