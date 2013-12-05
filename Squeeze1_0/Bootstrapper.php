<?php

namespace Squeeze1_0
{
  use \Squeeze1_0\Implementable\iBootstrapper;
  use \Squeeze1_0\Core\Activation as CoreActivation;
  use \Squeeze1_0\Core\Deactivation as CoreDeactivation;
  use \Squeeze1_0\Core\Finder;

  /**
   * @since 1.0
   */
  class Bootstrapper implements iBootstrapper
  {
    /**
     * @since 1.0
     */
    protected $bootstrapperFolder = 'Bootstrapper';

    /**
     * @since 1.0
     */
    protected $scanCoreFolder = true;

    /**
     * @since 1.0
     */
    private static $instance;

    /**
     * @since 1.0
     */
    private static $appEnv = array();

    /**
     * @since 1.0
     */
    public static function init($appOptions)
    {
      if (!is_a(self::$instance, __CLASS__)) {
        self::$instance = new self;
      }

      if ($appOptions['composer']) {
        self::$instance->loadVendorPackages($appOptions);
      }

      $env = self::$appEnv[$appOptions['app_name']] = self::$instance->loadEnvironmentObject($appOptions);
      self::$instance->activationHooks($env);
      $appBootstrapper = self::$instance->loadAppBootstrapper($env);

      self::$instance->bootstrap($env);

      if ($appBootstrapper && method_exists($appBootstrapper, 'afterBootstrap')) {
        $appBootstrapper->afterBootstrap();
      }
    }

    /**
     * @since 1.0
     */
    public function bootstrap(EnvironmentVariables $env = null)
    {
      $this->loadBootstrappers($env, $this->bootstrapperFolder, $this->scanCoreFolder);

      return;
    }

    /**
     * @since 1.0
     */
    protected function loadBootstrappers(EnvironmentVariables $env, $folder, $scanCoreFolder = false)
    {
      foreach (Finder::listFilesInDirectory($env, $folder, $scanCoreFolder) as $filename => $bootstrapper) {
        $bootstrapper = (array) $bootstrapper;

        if (class_exists($bootstrapper['FQCN'])) {
          $currentBootstrapper = new $bootstrapper['FQCN'];

          if (!isset($currentBootstrapper->ignore) || !$currentBootstrapper->ignore) {
            $currentBootstrapper->bootstrap($env);
          }

          $this->loadedBootstrappers[$bootstrapper['FQCN']] = $currentBootstrapper;
        }
      }
    }

    /**
     * @since 1.0
     */
    private function loadVendorPackages($appOptions)
    {
      if (is_array($appOptions['composer'])) {
        $composer_path = $appOptions['composer']['path'] .'/autoload.php';
      }
      else {
        $composer_path = $appOptions['app_path'] .'/vendor/autoload.php';
      }

      if ( \file_exists($composer_path) ) {
        require_once $composer_path;
      }
      else {
        throw new Exception('Packagist packages not installed where expected (Expected Path: '. $composer_path .')');
      }
    }

    /**
     * @since 1.0
     */
    private function loadEnvironmentObject($appOptions)
    {
      if (!$appOptions['environment']) {
        $env = new EnvironmentVariables;
      };

      $class = Finder::findClassInNamespace('EnvironmentVariables', $appOptions['app_namespace'], $appOptions['app_path']);
      if ($class) {
        $env = new $class($appOptions['environment']);
      }
      else {
        $env = new EnvironmentVariables($appOptions['environment']);
      }

      $env->setAppOptions($appOptions);

      return $env;
    }

    /**
     * @since 1.0
     */
    private function loadAppBootstrapper(EnvironmentVariables $env)
    {
      $class = Finder::findClassInNamespace('Bootstrapper', $env->getAppOptions('app_namespace'));
      if ($class) {
        $bootstrapper = new $class($env);

        return $bootstrapper;
      }

      return null;
    }

    /**
     * @since 1.0
     */
    private function activationHooks(EnvironmentVariables $env)
    {
      $pluginFilePath = $env->getAppOptions('app_path') .'/'. $env->getAppOptions('filename');

      $activation = Finder::findClassInNamespace('Activation', $env->getAppOptions('app_namespace'));
      if ($activation) {
        $activationObject = new $activation;
        register_activation_hook( $pluginFilePath, array($activationObject, 'bootstrap') );
      }

      $deactivation = Finder::findClassInNamespace('Deactivation', $env->getAppOptions('app_namespace'));
      if ($deactivation) {
        $deactivationObject = new $deactivation;
        register_deactivation_hook( $pluginFilePath, array($deactivationObject, 'bootstrap') );
      }

      $coreActivation = new CoreActivation($env);
      register_activation_hook($pluginFilePath, array($coreActivation, 'execute'));

      $coreDeactivation = new CoreDeactivation($env);
      register_deactivation_hook($pluginFilePath, array($coreDeactivation, 'execute'));
    }
  }
}