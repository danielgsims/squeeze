<?php

namespace Squeeze1_0\Mvc;

// This isn't implemented yet.
class PageController
{
  protected $appOptions;

  public function pre()
  {}

  public function bootstrap($appOptions)
  {
    $this->appOptions = $appOptions;
  }
}