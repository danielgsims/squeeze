<?php

namespace Squeeze\Core\Mvc;

class AdminPageController
{
  private $view;

  public function __construct()
  {
    $this->view = new \Squeeze\Core\View;

  }

  public function pre()
  {}

  public function bootstrap()
  {
    // This is where we'll create the menu item and whatever else. Extendable too.
  }
}