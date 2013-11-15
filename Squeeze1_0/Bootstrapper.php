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
    private static $appOptions = array();

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

      return self::$instance->bootstrap($appOptions);
    }

    public function bootstrap($appOptions) {
      $this->loadVendorPackages($appOptions);
      $this->activationHooks($appOptions);

      self::$appOptions[$appOptions['app_name']] = $appOptions;

      foreach ($this->listFilesInDirectory($appOptions, 'Bootstrappers', true) as $bootstrapper) {
        if(class_exists($bootstrapper['FQCN'])) {
          $this->loadedBootstrappers[$bootstrapper['FQCN']] = new $bootstrapper['FQCN'];
          $this->loadedBootstrappers[$bootstrapper['FQCN']]->bootstrap($appOptions);
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
     * @param array $appOptions
     * @param string $directory
     * @param bool $includeCoreDir If set to true, will attempt to fetch files from core directory of the same name and merge with app directory contents.
     */
    protected function listFilesInDirectory($appOptions, $directory, $includeCoreDir = false)
    {
      // FQCN = Fully Qualified Class Name

      $app_dir = $appOptions['app_path'] . $directory;
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
            'FQCN' => $appOptions['app_namespace'] .'\\'. $namespaceDir .'\\'. $className
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
  }
}