<?php

namespace Squeeze1_0\Util;

/**
 * A utility to create a table from an array, object, or PDO object
 */
class Table
{
  private $options = array();

  public function __construct($data, $options = array())
  {
    $this->data = $data;
    $this->options = $options;
  }

  public function execute()
  {
    $rows = array();

    $rows[] = $this->tableHeader();
  }

  public function setOption($key, $val)
  {
    $this->options[$key] = $val;
    return $this;
  }

  public function tableHeader()
  {
    $columns = $options['columns'];
  }
}