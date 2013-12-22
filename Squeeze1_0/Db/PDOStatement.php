<?php

namespace Squeeze1_0\Db
{

  use \PDOStatement as defaultPDOStatement;

  /**
   * Extends PHP's core PDOStatement class.
   *
   * Provides a bit of additional query debugging and a few utility functions.
   * @since 1.0
   */
  class PDOStatement extends defaultPDOStatement
  {

    /**
     * @since 1.0
     */
    protected $_debugValues = null;

    /**
     * @since 1.0
     */
    public $dbh;

    /**
     * @since 1.0
     */
    protected function __construct($dbh) {
      $this->dbh = $dbh;
    }

    /**
     * @since 1.0
     */
    public function execute($values=array())
    {
      $this->_debugValues = $values;
      try {
        $t = parent::execute($values);
        // maybe do some logging here?
      } catch (\PDOException $e) {
        // maybe do some logging here?
        throw $e;
      }

      return $t;
    }

    /**
     * @since 1.0
     */
    public function _debugQuery($replaced=true)
    {
      $q = $this->queryString;

      if (!$replaced) {
        return $q;
      }

      return preg_replace_callback('/:([0-9a-z_]+)/i', array($this, '_debugReplace'), $q);
    }

    /**
     * @since 1.0
     */
    protected function _debugReplace($m)
    {
      $v = $this->_debugValues[$m[1]];
      if ($v === null) {
        return "NULL";
      }
      if (!is_numeric($v)) {
        $v = str_replace("'", "''", $v);
      }

      return "'". $v ."'";
    }

    /**
     * @since 1.0
     */
    public function insertId()
    {
      return $this->dbh->lastInsertId();
    }
  }
}