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
    protected $bootstrapperFolder = 'Controller';

    /**
     * @since 1.0
     */
    protected $scanCoreFolder = false;

    /**
     * @since 1.0
     */
    private $loadedControllers = array();

    /**
     * @since 1.0
     */
    private $controllers = array();
  }
}