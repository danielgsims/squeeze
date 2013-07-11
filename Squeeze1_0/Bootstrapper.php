<?php

namespace Squeeze1_0
{
  class Bootstrapper
  {
    private static $instance;

    private static $appOptions = array();

    private $loadedControllers = array();
    private $controllers = array();

    private $loadedPostTypes = array();
    private $postTypes = array();

    private $loadedVendors = array();
    private $vendors = array();

    public static function init($appOptions)
    {
      if (!is_a(self::$instance, self)) {
        self::$instance = new self;
      }

      self::$instance->loadVendorPackages($appOptions);

      self::$instance->mapControllers($appOptions);
      self::$instance->mapPostTypes($appOptions);
      self::$instance->activationHooks($appOptions);

      self::$appOptions[$appOptions['app_name']] = $appOptions;

      return;
    }

    private function mapControllers($appOptions)
    {
      $dirMembers = $this->listFilesInDirectory($appOptions, 'App/Controller');

      array_walk($dirMembers, function($arr) {
        if(strpos($arr, '.php') !== false) {
          $this->controllers[] = str_replace('.php', '', $arr);
        }
      });

      foreach($this->controllers as $class) {
        $controllerName = $appOptions['app_namespace'] .'\App\Controller\\'. $class;
        $test = new $controllerName;
        if(class_exists($controllerName)) {
          $this->loadedControllers[$class] = new $controllerName;
          $this->loadedControllers[$class]->bootstrap($appOptions);
        }
      }
    }

    private function mapPostTypes($appOptions)
    {
      $dirMembers = $this->listFilesInDirectory($appOptions, 'App/PostType');

      array_walk($dirMembers, function($arr) {
        if(strpos($arr, '.php') !== false) {
          $this->postTypes[] = str_replace('.php', '', $arr);
        }
      });

      foreach($this->postTypes as $class) {
        $postTypeName = $appOptions['app_namespace'] .'\App\PostType\\'. $class;

        if(class_exists($postTypeName)) {
          $this->loadedPostTypes[$class] = new $postTypeName;
          $this->loadedPostTypes[$class]->bootstrap($appOptions);
        }
      }
    }

    private function loadVendorPackages($appOptions)
    {
      if ( \file_exists($appOptions['app_path'] .'/vendor/autoload.php') ) {
        require $appOptions['app_path'] .'/vendor/autoload.php';
      }
      else {
        throw new Exception('Packagist packages not installed');
      }
    }

    private function activationHooks($appOptions)
    {
      $pluginFilePath = $appOptions['app_path'] .'/'. $appOptions['filename'];

      if (class_exists($appOptions['app_namespace'] .'App\Activation')) {
        $activationObject = $appOptions['app_namespace'] .'App\Activation';
        register_activation_hook( $pluginFilePath, array($activationObject::instance(), 'activation') );
      }

      if (class_exists($appOptions['app_namespace'] .'App\Deactivation')) {
        $deactivationObject = $appOptions['app_namespace'] .'App\Deactivation';
        register_activation_hook( $pluginFilePath, array($deactivationObject::instance(), 'deactivation') );
      }
    }

    private function listFilesInDirectory($appOptions, $directory)
    {
      return scandir($appOptions['app_path'] . $directory);
    }
  }
}