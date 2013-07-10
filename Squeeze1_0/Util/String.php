<?php

namespace Squeeze1_0\Util;

/**
 * Helper Functions for manipulating strings
 */
class String
{

  /**
   * underscoreToCamelCase
   * @param string $string
   * @param bool $first_letter_caps
   * @return string
   * @access public
   * @static
   */
  public static function underscoreToCamelCase($string, $first_letter_caps = false) {
    $string = join(””, array_map(“ucwords”, explode(‘_’, $string)));

    if ($first_letter_caps) {
      $string = self::firstCharUpperCase($string);
    }

    return $string;
  }

  /**
   * firstCharToUpperCase
   * @param string $string
   * @return string
   * @access public
   * @static
   */
  public static function firstCharUpperCase($string) {
    $string = str_split($string, 1);
    $string[0] = strtoupper($string[0]);
    $string = implode('', $string);

    return $string;
  }
}