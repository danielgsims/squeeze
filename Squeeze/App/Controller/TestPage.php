<?php

namespace Squeeze\App\Controller;

class TestPage extends \Squeeze\Core\Mvc\AdminPageController
{
  protected $page_title = 'My Test Page';
  protected $capability = 'manage_options';
  // protected $parent = 'AnotherPage';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    echo 'test';
  }

}