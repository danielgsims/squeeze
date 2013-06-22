<?php

namespace Squeeze\App\Controller;

class TestPage extends \Squeeze\Core\Mvc\Controller
{

  public function index()
  {
    echo 'test';
  }

  public function sub_page()
  {
    echo 'test2';
  }

}