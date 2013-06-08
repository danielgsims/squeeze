<?php

/**
 * SQ_User
 * Adds a layer of functionality on top of the default WP_User class.
 * @extends WP_User
 */
class SQ_User extends WP_User {

  /**
   * These are all the fields that are exempted from being saved as usermeta.
   * @var array $insert_fields
   * @access private
   */
  private $insert_fields = array(
    'ID', 'user_pass', 'user_login', 'user_nicename', 'user_url', 'user_email', 'display_name', 'nickname', 'first_name', 'last_name', 'description', 'rich_editing', 'user_registered', 'role', 'jabber', 'aim', 'yim'
  );

  /**
   * @param $key string
   * @return string
   * @is_chainable false
   */
  public function get($key) {
    return $this->__get($key);
  }

  /**
   * @param $key string
   * @param $value string
   * @return object
   * @is_chainable true
   */
  public function set($key, $value) {
    $value = SQ_Input::sanitize($value);

    // meh. I'll go ahead and fix a wordpress error. -_-
    if(!is_object($this->data)) {
      $this->data = new stdClass();
    }

    $this->__set($key, $value);
    update_user_meta($this->user_id, $key, $value);

    return $this;
  }

  public function save() {
    if($this->ID !== 0 && isset($this->data->user_pass)) {
      $this->data->user_pass = wp_hash_password($this->data->user_pass);
    }

    $this->ID = wp_insert_user($this);

    foreach($this->data as $key=>$val) {
      if(!in_array($key, $this->insert_fields)) {
        update_user_meta($this->ID, $key, $val);
      }
    }

    return $this;
  }
}