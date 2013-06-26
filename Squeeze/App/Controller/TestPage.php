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
    $PDO = \Squeeze\Core\Db\PDO::instance();
    $query = $PDO->query('SELECT * FROM wp_posts LIMIT 1');

    $post = $query->fetch();
    $mustache = new \Mustache_Engine(array(
      'loader' => new \Mustache_Loader_FilesystemLoader(\SQ_PLUGIN_PATH .'/Squeeze/App/Views')
    ));
    $template = $mustache->loadTemplate('Test');
    echo $template->render($post);
  }

}