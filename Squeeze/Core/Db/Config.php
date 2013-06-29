<?php

namespace Squeeze\Core\Db
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