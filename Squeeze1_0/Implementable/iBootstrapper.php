<?php

namespace Squeeze1_0\Implementable
{
  use \Squeeze1_0\EnvironmentVariables;

  interface iBootstrapper
  {
    public function bootstrap(EnvironmentVariables $env = null);
  }
}