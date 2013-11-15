<?php

namespace Squeeze1_0\Bootstrappers
{
  use \Squeeze1_0\Bootstrapper;

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
    public function bootstrap($appOptions)
    {
      foreach ($this->listFilesInDirectory($appOptions, 'App/Widget') as $bootstrapper) {
        if(class_exists($bootstrapper['FQCN'])) {
          $this->loadedWidget[$bootstrapper['FQCN']] = new $bootstrapper['FQCN'];
          $this->loadedWidget[$bootstrapper['FQCN']]->bootstrap($appOptions);
        }
      }
    }
  }
}