<?php

namespace Squeeze1_0\Bootstrapper
{
  use Squeeze1_0\Bootstrapper;
  use Squeeze1_0\EnvironmentVariables;

  class Widgets extends Bootstrapper
  {
    /**
     * @since 1.0
     */
    protected $bootstrapperFolder = 'Widget';

    /**
     * @since 1.0
     */
    protected $scanCoreFolder = false;

    /**
     * @since 1.0
     */
    private $loadedWidgets = array();

    /**
     * @since 1.0
     */
    private $widgets = array();
  }
}