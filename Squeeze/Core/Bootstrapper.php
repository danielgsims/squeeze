<?php

namespace Squeeze\Core;

use \Squeeze\App\Controller as Controller;

class Bootstrapper
{
  private static $instance;

  public static function init()
  {
    self::$instance = new self;

    self::$instance->mapControllers();

    return;
  }

  private function mapControllers()
  {
    $this->controllers = array();
    $dirMembers = scandir(\SQ_PLUGIN_PATH .'/Squeeze/App/Controller');

    array_walk($dirMembers, function($arr) {
      if(strpos($arr, '.php') !== false) {
        $this->controllers[] = str_replace('.php', '', $arr);
      }
    });

    foreach($this->controllers as $controller) {
      $controllerName = '\Squeeze\App\Controller\\'. $controller;
      $this->$controller = new $controllerName;
      $this->$controller->bootstrap();
    }
  }
}