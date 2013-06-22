<?php

namespace Squeeze\Core;

class Bootstrapper
{
  private static $instance;
  private $loadedControllers = array();
  private $controllers = array();

  public static function init()
  {
    self::$instance = new self;

    self::$instance->mapControllers();

    return;
  }

  private function mapControllers()
  {
    $dirMembers = scandir(\SQ_PLUGIN_PATH .'/Squeeze/App/Controller');

    array_walk($dirMembers, function($arr) {
      if(strpos($arr, '.php') !== false) {
        $this->controllers[] = str_replace('.php', '', $arr);
      }
    });

    foreach($this->controllers as $class) {
      $controllerName = '\Squeeze\App\Controller\\'. $class;

      if(class_exists($controllerName)) {
        $this->loadedControllers[$class] = new $controllerName;
        $this->loadedControllers[$class]->bootstrap();
      }
    }
  }
}