<?php

namespace Squeeze1_0\Bootstrapper
{
  use \Squeeze1_0\Bootstrapper;
  use \Squeeze1_0\EnvironmentVariables;

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
    public function bootstrap(EnvironmentVariables $env = null)
    {
      foreach ($this->listFilesInDirectory($env, 'Controller') as $bootstrapper) {
        if(class_exists($bootstrapper['FQCN'])) {
          $this->loadedControllers[$bootstrapper['FQCN']] = new $bootstrapper['FQCN'];
          $this->loadedControllers[$bootstrapper['FQCN']]->bootstrap($env);
        }
      }
    }
  }
}