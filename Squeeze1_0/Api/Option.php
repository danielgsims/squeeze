<?php

namespace Squeeze1_0\Api
{
  use \arrayaccess;

  /**
   * A class to get, set and manage settings stored in the WordPress database.
   *
   * For each option, create a new instance of this API.
   * @since 1.0
   */
  class Option implements arrayaccess
  {

    /**
     * @var string
     * @access protected
     * @since 1.0
     */
    protected $getter = 'get_option';

    /**
     * @var string
     * @access protected
     * @since 1.0
     */
    protected $setter = 'update_option';

    /**
     * @var
     * @access protected
     * @since 1.0
     */
    protected $deleter = 'delete_option';

    /**
     * @var string
     * @access protected
     * @since 1.0
     */
    protected $key;

    /**
     * @var mixed
     * @access protected
     * @since 1.0
     */
    protected $value;

    /**
     * @var string
     * @access protected
     * @since 1.0
     */
    protected $encoding_type;

    /**
     * Take a given key, fetch the value from the database and attempt to determine encoding type.
     * @param string $key
     * @return null
     * @access public
     * @since 1.0
     */
    public function __construct($key, $forceAsArray = false)
    {
      $getter_func = $this->getter;

      $this->key = $key;
      $this->value = $getter_func($key);

      if (!$this->value) {
        $this->encoding_type = 'json';
      }
      else {
        if ($this->isJson($this->value)) {
          $this->value = json_decode($this->value, true);
          $this->encoding_type = 'json';
        }
      }
    }

    /**
     * Return the stored value.
     * @return mixed
     * @access public
     * @since 1.0
     */
    public function get() {
      return $this->value;
    }

    /**
     * Update the value
     * @param mixed $value
     * @return Options $this
     * @access public
     * @since 1.0
     */
    public function set($value) {
      $this->value = $value;
      return $this;
    }

    /**
     * If the stored value is an array, add a value to the end.
     * If a key and value are specified, the given key will be used in the stored value.
     * If not, we'll push onto the end of the array with a default key.
     * @param mixed $keyOrValue
     * @param mixed $value
     * @return Options $this
     * @access public
     * @since 1.0
     */
    public function push($keyOrValue, $value = null) {
      if (!is_array($this->value)) return false;

      if (is_null($value)) {
        array_push($this->value, $keyOrValue);
      }
      else {
        $this->value[$keyOrValue] = $value;
      }

      return $this;
    }

    /**
     * Save the value to the database.
     * If the value was previously stored as json, it'll be re-encoded as json.
     * Any other types will be left to WordPress to determine.
     * @access public
     * @return bool
     * @since 1.0
     */
    public function save()
    {
      $value = $this->value;
      if ($this->encoding_type == 'json' && (is_object($this->value) || is_array($this->value)) ) {
        $value = json_encode($value);
      }

      $this->executeSave($value);

      return true;
    }

    protected function executeSave($value)
    {
      $setter_func = $this->setter;
      $setter_func($this->key, $value);
    }

    /**
     * Determine if a string is json-encoded
     * @access private
     * @param string $string
     * @return bool
     * @since 1.0
     */
    private function isJson($string)
    {
      json_decode($string);
      return (json_last_error() == JSON_ERROR_NONE);
    }

    public function offsetSet($offset, $value) {
      if (is_null($offset)) {
        $this->value[] = $value;
      }
      else {
        $this->value[$offset] = $value;
      }
    }

    public function offsetExists($offset) {
      return isset($this->value[$offset]);
    }

    public function offsetUnset($offset) {
      unset($this->value[$offset]);
    }

    public function offsetGet($offset) {
      return isset($this->value[$offset]) ? $this->value[$offset] : null;
    }
  }
}