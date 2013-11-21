<?php

namespace Squeeze1_0\Core
{
  use \Squeeze1_0\EnvironmentVariables;

  class Finder
  {
    /**
     * @since 1.0
     * @param array $appOptions
     * @param string $directory
     * @param bool $includeCoreDir If set to true, will attempt to fetch files from core directory of the same name and merge with app directory contents.
     */
    public static function listFilesInDirectory(EnvironmentVariables $env, $directory, $includeCoreDir = false)
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
    public static function findClassInNamespace($class_name, $namespace)
    {
      $fqcn = $namespace .'\\'. $class_name;

      if (class_exists($fqcn)) {
        return $namespace .'\\'. $class_name;
      }

      return false;
    }
  }
}