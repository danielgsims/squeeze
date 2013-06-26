<?php

namespace Squeeze\App\Controller;

class TestPage extends \Squeeze\Core\Mvc\AdminPageController
{
  protected $page_title = 'My Test Page';
  protected $capability = 'manage_options';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $PDO = \Squeeze\Core\Db\PDO::instance();
    $query = $PDO->query('SELECT * FROM wp_posts LIMIT 1');

    $post = $query->fetch();
    $mustache = new \Squeeze\Core\Mustache;
    $template = $mustache->loadTemplate('Test');
    echo $template->render($post);
  }

}