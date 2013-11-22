<?php

namespace Squeeze1_0\Api
{
  /**
   * A class to get, set and manage transient settings stored in the WordPress database.
   *
   * For each transient, create a new instance of this API.
   * @since 1.0
   */
  class Transient extends Option
  {
    /**
     * @var string
     * @access protected
     * @since 1.0
     */
    protected $setter = 'set_transient';

    /**
     * @var string
     * @access protected
     * @since 1.0
     */
    protected $getter = 'get_transient';

    /**
     * @var
     * @access protected
     * @since 1.0
     */
    protected $deleter = 'delete_transient';

    /**
     * @var string
     * @access private
     * @since 1.0
     */
    private $expiration = 86400;

    public function setExpiration($timestamp)
    {
      $this->expiration = $timestamp;
      return $this;
    }

    protected function executeSave($value)
    {
      $setter_func = $this->setter;
      $setter_func($this->key, $value, $this->expiration);
    }
  }
}