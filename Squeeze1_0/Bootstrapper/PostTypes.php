<?php

namespace Squeeze1_0\Bootstrapper
{
  use Squeeze1_0\Bootstrapper;
  use Squeeze1_0\EnvironmentVariables;

  class PostTypes extends Bootstrapper
  {
    /**
     * @since 1.0
     */
    protected $bootstrapperFolder = 'PostType';

    /**
     * @since 1.0
     */
    protected $scanCoreFolder = false;

    /**
     * @since 1.0
     */
    private $loadedPostTypes = array();

    /**
     * @since 1.0
     */
    private $postTypes = array();
  }
}