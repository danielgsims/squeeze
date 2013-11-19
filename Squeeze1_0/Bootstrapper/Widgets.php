<?php

namespace Squeeze1_0\Bootstrapper
{
  use \Squeeze1_0\Bootstrapper;
  use \Squeeze1_0\EnvironmentVariables;

  class Widgets extends Bootstrapper
  {
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
    public function bootstrap(EnvironmentVariables $env = null)
    {
      foreach ($this->listFilesInDirectory($env, 'Widget') as $bootstrapper) {
        if(class_exists($bootstrapper['FQCN'])) {
          $this->loadedWidget[$bootstrapper['FQCN']] = new $bootstrapper['FQCN'];
          $this->loadedWidget[$bootstrapper['FQCN']]->bootstrap($env);
        }
      }
    }
  }
}