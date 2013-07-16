<?php

namespace Squeeze1_0\Implementable
{
  /**
   * Base implementation required to autoload a Squeeze controller.
   * @since 1.0
   */
  interface iController
  {

    /**
     * @since 1.0
     */
    public function pre();

    /**
     * @since 1.0
     */
    public function index();

    /**
     * @since 1.0
     */
    public function bootstrap($appOptions);
  }
}