<?php

namespace Squeeze1_0\Implementable
{
  use \Squeeze1_0\EnvironmentVariables;

  interface iBootstrapper
  {
    /**
     * @since 1.0
     */
    public function bootstrap(EnvironmentVariables $env = null);
  }
}