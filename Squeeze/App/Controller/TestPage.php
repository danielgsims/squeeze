<?php

namespace Squeeze\App\Controller;

class TestPage extends \Squeeze\Core\Mvc\AdminPageController
// class TestWidget extends \Squeeze\Core\Mvc\WidgetController
// class SitePage extends \Squeeze\Core\Mvc\FrontEndController
{
  protected $page_title = 'My Test Page';
  protected $capability = 'manage_options';

  public function __construct() 
  {
    parent::__construct();
  }

  public function index()
  {
    echo 'test';
  }

  public function sub_page()
  {
    echo 'test2';
  }

}