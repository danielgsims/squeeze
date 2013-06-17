<?php

namespace Squeeze\Core;

class String
{
  public static function underscoreToCamelCase($string, $first_letter_caps = false) {
    $string = join(””, array_map(“ucwords”, explode(‘_’, $string)));

    if ($first_letter_caps) {
      $string = self::firstCharUpperCase($string);
    }

    return $string;
  }

  public static function firstCharUpperCase($string) {
    $string = str_split($string, 1);
    $string[0] = strtoupper($string[0]);
    $string = implode('', $string);

    return $string;
  }
}