<?php

namespace Squeeze\App\Controller;

class MyDashboardWidget extends \Squeeze\Core\Mvc\DashboardWidget
{
  protected $title = 'Squeezed Widget';

  public function index()
  {
    echo 'test';
  }
}