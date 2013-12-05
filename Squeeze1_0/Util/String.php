<?php

namespace Squeeze1_0\Util
{
  /**
   * Helper Functions for manipulating strings
   * @since 1.0
   */
  class String
  {

    /**
     * Convert an underscore separated string to camelcase
     * @param string $string
     * @param bool $first_letter_caps
     * @return string
     * @access public
     * @static
     * @since 1.0
     */
    public static function underscoreToCamelCase($string, $first_letter_caps = false) {
      $string = join('', array_map('ucwords', explode('_', $string)));

      if (!$first_letter_caps) {
        $string = self::firstCharLowerCase($string);
      }

      return $string;
    }

    public static function firstCharLowerCase($string)
    {
      return lcfirst($string);
    }

    /**
     * Convert the first character of a string to uppercase.
     * @param string $string
     * @return string
     * @access public
     * @static
     * @since 1.0
     */
    public static function firstCharUpperCase($string) {
      return ucfirst($string);
    }
  }
}