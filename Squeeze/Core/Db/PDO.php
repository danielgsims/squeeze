<?php

namespace Squeeze\Core\Db;

class PDO extends \PDO
{
  private static $instance;

  public function __construct() {
    if (!is_object(self::$instance)) {
      parent::__construct('mysql:host='. \DB_HOST .';dbname='. \DB_NAME, \DB_USER, \DB_PASSWORD);
      $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $this->setAttribute(\PDO::ATTR_STATEMENT_CLASS, array('\Squeeze\Core\Db\PDOStatement', array($this)));

      self::$instance = $this;
    }
  }

  public static function instance()
  {
    if (!is_object(self::$instance)) {
      return new self;
    }
  }
}