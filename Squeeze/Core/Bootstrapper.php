<?php

namespace Squeeze\Core;

class Bootstrapper
{
  private static $instance;

  private $loadedControllers = array();
  private $controllers = array();

  private $loadedVendors = array();
  private $vendors = array();

  public static function init()
  {
    if (!is_a(self::$instance, self)) {
      self::$instance = new self;
    }

    self::$instance->mapControllers();
    self::$instance->loadVendorPackages();
    self::$instance->activationHooks();

    return;
  }

  private function mapControllers()
  {
    $dirMembers = $this->listFilesInDirectory('Squeeze/App/Controller');

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

  private function loadVendorPackages()
  {
    if ( \file_exists(\SQ_PLUGIN_PATH .'/vendor/autoload.php') ) {
      require \SQ_PLUGIN_PATH .'/vendor/autoload.php';
    }
    else {
      throw new Exception('Packagist packages not installed');
    }
  }

  private function activationHooks()
  {
    $pluginFilePath = \SQ_PLUGIN_PATH .'/'. \SQ_PLUGIN_FILENAME;

    if (class_exists('\Squeeze\App\Activation')) {
      $activationObject = '\Squeeze\App\Activation';
    }
    else {
      $activationObject = '\Squeeze\Core\Activation';
    }

    if (class_exists('\Squeeze\App\Deactivation')) {
      $deactivationObject = '\Squeeze\App\Deactivation';
    }
    else {
      $deactivationObject = '\Squeeze\Core\Deactivation';
    }

    register_activation_hook( $pluginFilePath, array($activationObject::instance(), 'activation') );
    register_activation_hook( $pluginFilePath, array($deactivationObject::instance(), 'deactivation') );
  }

  private function listFilesInDirectory($directory)
  {
    return scandir(\SQ_PLUGIN_PATH .'/'. $directory);
  }
}