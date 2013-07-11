<?php

namespace Squeeze1_0
{

  /**
   * Allows running operations at deactivation.
   */
  abstract class Deactivation
  {

    /**
     * @var object
     * @static
     */
    private static $instance;

    /**
     * Create a singleton
     * @return object \Squeeze1_0\Activation
     * @static
     * @final
     */
    public final static function instance()
    {
      if (!is_a(self::$instance, self)) {
        self::$instance = new self;
      }

      return self::$instance;
    }

    /**
     * The deactivation function.
     *
     * Implementations of this class must provide an deactivation function.
     * @abstract
     */
    public function deactivation()
    {}

  }

}