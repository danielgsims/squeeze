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
      return self::$instance->bootstrap();
    }

    public function bootstrap(EnvironmentVariables $env = null) {
      if ($this->appOptions['enable_composer']) {
        $this->loadVendorPackages($this->appOptions);
      }

      $env = $this->loadEnvironmentObject($this->appOptions);
      $this->activationHooks($env);
      $this->loadAppBootstrapper($env);

      foreach ($this->listFilesInDirectory($env, 'Bootstrappers', true) as $bootstrapper) {
        if(class_exists($bootstrapper['FQCN'])) {
          $this->loadedBootstrappers[$bootstrapper['FQCN']] = new $bootstrapper['FQCN'];
          $this->loadedBootstrappers[$bootstrapper['FQCN']]->bootstrap($env);
        }
      }

      return;
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
    private function loadEnvironmentObject($appOptions)
    {
      if (!$appOptions['environment']) {
        $env = new EnvironmentVariables;
      };

      $class = $this->findClassInNamespace('EnvironmentVariables', $appOptions['app_namespace']);
      if ($class) {
        $env = new $class($appOptions['environment']);
      }

      $env->setAppOptions($appOptions);

      return $env;
    }

    private function loadAppBootstrapper(EnvironmentVariables $env)
    {
      $class = $this->findClassInNamespace('Bootstrapper', $env->getAppOptions('app_namespace'));
      if ($class) {
        $env = new $class($env);
      }
    }

    /**
     * @since 1.0
     */
    private function activationHooks(EnvironmentVariables $env)
    {
      $pluginFilePath = $env->getAppOptions('app_path') .'/'. $env->getAppOptions('filename');

      if (class_exists($env->getAppOptions('app_namespace') .'App\Activation')) {
        $activationObject = $env->getAppOptions('app_namespace') .'App\Activation';
        register_activation_hook( $pluginFilePath, array($activationObject::instance(), 'activation') );
      }

      if (class_exists($env->getAppOptions('app_namespace') .'App\Deactivation')) {
        $deactivationObject = $env->getAppOptions('app_namespace') .'App\Deactivation';
        register_activation_hook( $pluginFilePath, array($deactivationObject::instance(), 'deactivation') );
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
            'FQCN' => $env->getAppOptions('app_namespace') .'\\'. $namespaceDir .'\\'. $className
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
            'FQCN' => 'Squeeze1_0\\'. $namespaceDir .'\\'. $className
          );
        }

        return array_merge($coreDirFiltered, $appDirFiltered);
      }

      return $appDirFiltered;
    }

    protected function findClassInNamespace($class_name, $namespace)
    {
      if (class_exists($namespace .'\\'. $class_name)) {
        return $namespace .'\\'. $class_name;
      }

      return false;
    }
  }
}