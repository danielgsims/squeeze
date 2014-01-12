<?php

namespace Squeeze1_0\Core
{
  use Squeeze1_0\EnvironmentVariables;
  use Squeeze1_0\Core\Finder;

  class Activation
  {
    public function __construct(EnvironmentVariables $env)
    {
      $this->env = $env;
    }

    public function execute()
    {
      $class = Finder::findClassInNamespace('SchedulerJobs', 'Squeeze1_0\\Bootstrapper');
      if ($class) {
        $scheduler = new $class;
        $scheduler->bootstrap($this->env);
      }
    }
  }
}