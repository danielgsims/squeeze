<?php

namespace Squeeze1_0\Db
{
  class Config
  {

    /**
     * prefix
     * Return the database prefix.
     * @return string
     * @uses object $wpdb
     */
    public static function prefix()
    {
      global $wpdb;
      return $wpdb->prefix;
    }
  }
}