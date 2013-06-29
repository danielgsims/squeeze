<?php

namespace Squeeze\App\Controller;

class AnotherPage extends \Squeeze\Core\Mvc\AdminPageController
{
  protected $page_title = 'Another Page';
  protected $capability = 'manage_options';
  protected $parent = 'posts';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    echo 'test';
  }
}