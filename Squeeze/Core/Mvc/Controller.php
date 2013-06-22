<?php

namespace Squeeze\Core\Mvc;

class Controller
{
  private $view;

  public function __construct()
  {
    $this->view = new \Squeeze\Core\View;
  }

  public function pre()
  {}
}