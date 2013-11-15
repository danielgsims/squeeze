<?php

namespace Squeeze1_0\Bootstrappers
{
  use \Squeeze1_0\Bootstrapper;

  class Controllers extends Bootstrapper
  {
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
    public function bootstrap($appOptions)
    {
      foreach ($this->listFilesInDirectory($appOptions, 'App/Controller') as $bootstrapper) {
        // print_r($bootstrapper);exit;
        if(class_exists($bootstrapper['FQCN'])) {
          $this->loadedControllers[$bootstrapper['FQCN']] = new $bootstrapper['FQCN'];
          $this->loadedControllers[$bootstrapper['FQCN']]->bootstrap($appOptions);
        }
      }
    }
  }
}