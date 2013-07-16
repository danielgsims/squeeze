<?php

namespace Squeeze1_0
{

  /**
   * Allows running operations at activation.
   * @since 1.0
   */
  abstract class Activation
  {

    /**
     * @var object
     * @static
     * @since 1.0
     */
    private static $instance;

    /**
     * Create a singleton
     * @return object \Squeeze1_0\Activation
     * @static
     * @final
     * @since 1.0
     */
    public final static function instance()
    {
      if (!is_a(self::$instance, self)) {
        self::$instance = new self;
      }

      return self::$instance;
    }

    /**
     * The activation function.
     *
     * Implementations of this class must provide an activation function.
     * @abstract
     * @since 1.0
     */
    public abstract function activation();
  }

}