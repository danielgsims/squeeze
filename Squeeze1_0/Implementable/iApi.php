<?php

namespace Squeeze1_0\Implementable
{
  /**
   * @since 1.0
   */
  interface iApi
  {
    /**
     * @since 1.0
     */
    public function get($key);

    /**
     * @since 1.0
     */
    public function set($key, $val);

    /**
     * @since 1.0
     */
    public function save();

    /**
     * @since 1.0
     */
    public function delete();

    /**
     * @since 1.0
     */
    public function trash();
  }
}