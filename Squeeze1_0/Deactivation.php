<?php

namespace Squeeze1_0
{

  /**
   * Allows running operations at deactivation.
   * @since 1.0
   */
  abstract class Deactivation
  {

    /**
     * @var object
     * @static
     * @since 1.0
     */
    private static $instance;

    /**
     * The deactivation function.
     *
     * Implementations of this class must provide an deactivation function.
     * @abstract
     * @since 1.0
     */
    public function bootstrap()
    {}

  }

}