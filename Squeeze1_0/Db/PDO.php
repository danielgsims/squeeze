<?php

namespace Squeeze1_0\Db;

class PDO extends \PDO
{
  private static $instance;

  public function __construct() {
    if (!is_a(self, self::$instance)) {
      parent::__construct('mysql:host='. \DB_HOST .';dbname='. \DB_NAME, \DB_USER, \DB_PASSWORD);
      $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $this->setAttribute(\PDO::ATTR_STATEMENT_CLASS, array('\Squeeze1_0\Db\PDOStatement', array($this)));

      self::$instance = $this;
    }

    return self::instance();
  }

  public static function instance()
  {
    if (!is_object(self::$instance)) {
      return new self;
    }
    return self::$instance;
  }
}