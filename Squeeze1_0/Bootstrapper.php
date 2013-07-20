<?php

namespace Squeeze1_0
{

  /**
   * @since 1.0
   */
  class Bootstrapper
  {
    /**
     * @since 1.0
     */
    private static $instance;

    /**
     * @since 1.0
     */
    private static $appOptions = array();

    /**
     * @since 1.0
     */
    private $loadedControllers = array();

    /**
     * @since 1.0
     */
    private $controllers = array();

    /**
     * @since 1.0
     */
    private $loadedPostTypes = array();

    /**
     * @since 1.0
     */
    private $postTypes = array();

    /**
     * @since 1.0
     */
    private $loadedWidgets = array();

    /**
     * @since 1.0
     */
    private $widgets = array();

    /**
     * @since 1.0
     */
    private $loadedVendors = array();

    /**
     * @since 1.0
     */
    private $vendors = array();

    /**
     * @since 1.0
     */
    public static function init($appOptions)
    {
      if (!is_a(self::$instance, self)) {
        self::$instance = new self;
      }

      self::$instance->loadVendorPackages($appOptions);

      self::$instance->mapControllers($appOptions);
      self::$instance->mapPostTypes($appOptions);
      self::$instance->mapWidgets($appOptions);
      self::$instance->activationHooks($appOptions);

      self::$appOptions[$appOptions['app_name']] = $appOptions;

      return;
    }

    /**
     * @since 1.0
     */
    private function mapControllers($appOptions)
    {
      $dirMembers = $this->listFilesInDirectory($appOptions, 'App/Controller');

      array_walk($dirMembers, function($arr) {
        if(strpos($arr, '.php') !== false) {
          $this->controllers[] = str_replace('.php', '', $arr);
        }
      });

      if (!empty($this->controllers)) {
        foreach($this->controllers as $class) {
          $controllerName = $appOptions['app_namespace'] .'\App\Controller\\'. $class;
          $test = new $controllerName;
          if(class_exists($controllerName)) {
            $this->loadedControllers[$class] = new $controllerName;
            $this->loadedControllers[$class]->bootstrap($appOptions);
          }
        }
      }
    }

    /**
     * @since 1.0
     */
    private function mapPostTypes($appOptions)
    {
      $dirMembers = $this->listFilesInDirectory($appOptions, 'App/PostType');

      array_walk($dirMembers, function($arr) {
        if(strpos($arr, '.php') !== false) {
          $this->postTypes[] = str_replace('.php', '', $arr);
        }
      });

      if (!empty($this->postTypes)) {
        foreach($this->postTypes as $class) {
          $postTypeName = $appOptions['app_namespace'] .'\App\PostType\\'. $class;

          if(class_exists($postTypeName)) {
            $this->loadedPostTypes[$class] = new $postTypeName;
            $this->loadedPostTypes[$class]->bootstrap($appOptions);
          }
        }
      }
    }

    /**
     * @since 1.0
     */
    private function mapWidgets($appOptions)
    {
      $dirMembers = $this->listFilesInDirectory($appOptions, 'App/Widget');

      array_walk($dirMembers, function($arr) {
        if(strpos($arr, '.php') !== false) {
          $this->widgets[] = str_replace('.php', '', $arr);
        }
      });

      if (!empty($this->widgets)) {
        foreach($this->widgets as $class) {
          $widgetName = $appOptions['app_namespace'] .'\App\Widget\\'. $class;

          if(class_exists($widgetName)) {
            $this->loadedWidget[$class] = new $widgetName;
            $this->loadedWidget[$class]->bootstrap($appOptions);
          }
        }
      }
    }

    /**
     * @since 1.0
     */
    private function loadVendorPackages($appOptions)
    {
      if ( \file_exists($appOptions['app_path'] .'/vendor/autoload.php') ) {
        require $appOptions['app_path'] .'/vendor/autoload.php';
      }
      else {
        throw new Exception('Packagist packages not installed');
      }
    }

    /**
     * @since 1.0
     */
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

    /**
     * @since 1.0
     */
    private function listFilesInDirectory($appOptions, $directory)
    {
      if (!file_exists($appOptions['app_path'] . $directory) ) return array();

      return scandir($appOptions['app_path'] . $directory);
    }
  }
}