<?php

namespace Squeeze\Core\Db;

class PDO extends \PDO
{
  public function __construct()
  {
    parent::__construct('mysql:host='. \DB_HOST .';dbname='. \DB_NAME, \DB_USER, \DB_PASSWORD);
    $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $this->setAttribute(\PDO::ATTR_STATEMENT_CLASS, array('\Squeeze\Core\Db\PDOStatement', array($this)));
  }
}