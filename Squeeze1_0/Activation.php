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
     * The activation function.
     *
     * Implementations of this class must provide an activation function.
     * @abstract
     * @since 1.0
     */
    public abstract function bootstrap();
  }

}