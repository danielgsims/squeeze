<?php

namespace Squeeze1_0\Db
{

  /**
   * Store for database configuration.
   * @since 1.0
   */
  class Config
  {

    /**
     * Return the database prefix.
     * @return string
     * @uses object $wpdb
     * @since 1.0
     */
    public static function prefix()
    {
      global $wpdb;
      return $wpdb->prefix;
    }
  }
}