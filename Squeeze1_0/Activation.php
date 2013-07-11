<?php

namespace Squeeze1_0
{

  /**
   * Allows running operations at activation.
   */
  abstract class Activation
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
     * The activation function.
     *
     * Implementations of this class must provide an activation function.
     * @abstract
     */
    public abstract function activation();
  }

}