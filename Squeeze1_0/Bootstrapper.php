<?php

namespace Squeeze1_0
{
  use \Squeeze1_0\Implementable\iBootstrapper;

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
    private $appOptions = array();

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

      self::$instance->appOptions = $appOptions;

      if (self::$instance->appOptions['composer']) {
        self::$instance->loadVendorPackages(self::$instance->appOptions);
      }

      $env = self::$instance->loadEnvironmentObject(self::$instance->appOptions);
      self::$instance->activationHooks($env);
      self::$instance->loadAppBootstrapper($env);

      return self::$instance->bootstrap($env);
    }

    /**
     * @since 1.0
     */
    public function bootstrap(EnvironmentVariables $env = null) {

      $this->loadBootstrappers($env, $this->bootstrapperFolder, $this->scanCoreFolder);

      return;
    }

    /**
     * @since 1.0
     */
    protected function loadBootstrappers(EnvironmentVariables $env, $folder, $scanCoreFolder = false)
    {
      foreach ($this->listFilesInDirectory($env, $folder, $scanCoreFolder) as $filename => $bootstrapper) {
        if(class_exists($bootstrapper['FQCN'])) {
          $this->loadedBootstrappers[$bootstrapper['FQCN']] = new $bootstrapper['FQCN'];

          if(!isset($this->loadedBootstrappers[$bootstrapper['FQCN']]->ignore) || !$this->loadedBootstrappers[$bootstrapper['FQCN']]->ignore) {
            $this->loadedBootstrappers[$bootstrapper['FQCN']]->bootstrap($env);
          }
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

      $class = $this->findClassInNamespace('EnvironmentVariables', $appOptions['app_namespace'], $appOptions['app_path']);
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
      $class = $this->findClassInNamespace('Bootstrapper', $env->getAppOptions('app_namespace'), $env->getAppOptions('app_path'));
      if ($class) {
        $bootstrapper = new $class($env);
      }
    }

    /**
     * @since 1.0
     */
    private function activationHooks(EnvironmentVariables $env)
    {
      $pluginFilePath = $env->getAppOptions('app_path') .'/'. $env->getAppOptions('filename');

      $activation = $this->findClassInNamespace('Activation', $env->getAppOptions('app_namespace'));
      if ($activation) {
        $activationObject = new $activation;
        register_activation_hook( $pluginFilePath, array($activationObject, 'bootstrap') );
      }

      $deactivation = $this->findClassInNamespace('Deactivation', $env->getAppOptions('app_namespace'));
      if ($deactivation) {
        $deactivationObject = new $deactivation;
        register_activation_hook( $pluginFilePath, array($deactivationObject, 'bootstrap') );
      }
    }

    /**
     * @since 1.0
     * @param array $appOptions
     * @param string $directory
     * @param bool $includeCoreDir If set to true, will attempt to fetch files from core directory of the same name and merge with app directory contents.
     */
    protected function listFilesInDirectory(EnvironmentVariables $env, $directory, $includeCoreDir = false)
    {
      // FQCN = Fully Qualified Class Name
      $app_dir = $env->getAppOptions('app_path') . $env->getAppOptions('app_name') .'/'. $directory;
      $core_dir =  SQ_CORE_PATH . '/Squeeze1_0/' . $directory;
      $namespaceDir = str_replace('/', '\\', $directory);

      $appDirContents = array();
      $coreDirContents = array();

      $appDirFiltered = array();
      $coreDirFiltered = array();

      if (file_exists($app_dir) ) {
        $appDirContents = scandir($app_dir);

        foreach ($appDirContents as $key=>$filename) {
          if(strpos($filename, '.php') === FALSE) continue;

          $className = str_replace('.php', '', $filename);
          $appDirFiltered[$filename] = array(
            'path' => $app_dir,
            'fileName' => $filename,
            'className' => $className,
            'FQCN' => '\\'. $env->getAppOptions('app_namespace') .'\\'. $namespaceDir .'\\'. $className
          );
        }
      }

      if ($includeCoreDir && file_exists($core_dir) ) {
        $coreDirContents = scandir($core_dir);

        foreach ($coreDirContents as $key=>$filename) {
          if(strpos($filename, '.php') === FALSE) continue;

          $className = str_replace('.php', '', $filename);
          $coreDirFiltered[$filename] = array(
            'path' => $core_dir,
            'fileName' => $filename,
            'className' => $className,
            'FQCN' => '\\Squeeze1_0\\'. $namespaceDir .'\\'. $className
          );
        }

        return array_merge($coreDirFiltered, $appDirFiltered);
      }

      return $appDirFiltered;
    }

    /**
     * @since 1.0
     */
    protected function findClassInNamespace($class_name, $namespace)
    {
      $fqcn = $namespace .'\\'. $class_name;

      if (class_exists($fqcn)) {
        return $namespace .'\\'. $class_name;
      }

      return false;
    }
  }
}