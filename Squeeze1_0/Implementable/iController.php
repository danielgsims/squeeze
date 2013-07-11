<?php

namespace Squeeze1_0\Implementable
{
  /**
   * Base implementation required to autoload a Squeeze controller.
   */
  interface iController
  {
    public function pre();
    public function index();
    public function bootstrap($appOptions);
  }
}