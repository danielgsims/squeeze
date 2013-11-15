<?php

namespace Squeeze1_0
{
  class EnvironmentVariables
  {
    private $appOptions;

    public function setAppOptions($appOptions)
    {
      $this->appOptions = $appOptions;
    }

    public function getAppOptions($key = null)
    {
      if (is_null($key)) {
        return $this->appOptions;
      }

      return $this->appOptions[$key];
    }
  }
}