<?php

namespace Squeeze1_0\Api
{
  /**
   * WordPress has a class called WP_Post
   *
   * Sort of like WP_User whoo!
   *
   * Oh wait, it's declared as final so I can't extend it
   *
   * Thanks a lot guys.
   */
  class Post
  {

    /**
     * Unimplemented
     */
    const TYPE_POST          = 'post';

    /**
     * Unimplemented
     */
    const TYPE_PAGE          = 'page';

    /**
     * Unimplemented
     */
    const TYPE_ATTACHMENT    = 'attachment';

    /**
     * Unimplemented
     */
    const TYPE_LINK          = 'link';

    /**
     * Unimplemented
     */
    const TYPE_NAV_MENU_ITEM = 'nav_menu_item';

    /**
     * Unimplemented
     */
    const TYPE_CUSTOM        = 'custom';

    /**
     * Unimplemented
     */
    const STATUS_DRAFT       = 'draft';

    /**
     * Unimplemented
     */
    const STATUS_PUBLISH     = 'publish';

    /**
     * Unimplemented
     */
    const STATUS_PENDING     = 'pending';

    /**
     * Unimplemented
     */
    const STATUS_FUTURE      = 'future';

    /**
     * Unimplemented
     */
    const STATUS_PRIVATE     = 'private';

    /**
     * Unimplemented
     */
    const STATUS_CUSTOM      = 'custom';

    /**
     * An array of all the meta fields on the loaded post.
     */
    private $meta = array();

    /**
     * The Post ID
     *
     * Database-driven value
     * @var int
     */
    private $ID;

    /**
     * Database-driven value
     * @var int
     */
    private $menu_order;

    /**
     * Database-driven value
     * @var string
     */
    private $comment_status;

    /**
     * Database-driven value
     * @var string
     */
    private $ping_status;

    /**
     * Database-driven value
     * @var string
     */
    private $pinged;

    /**
     * Database-driven value
     * @var int
     */
    private $post_author;

    /**
     * Database-driven value
     * @var string
     */
    private $post_content;

    /**
     * Database-driven value
     * @var datetime
     */
    private $post_date;

    /**
     * Database-driven value
     * @var datetime
     */
    private $post_date_gmt;

    /**
     * Database-driven value
     * @var string
     */
    private $post_excerpt;

    /**
     * Database-driven value
     * @var string
     */
    private $post_name;

    /**
     * Database-driven value
     * @var int
     */
    private $post_parent;

    /**
     * Database-driven value
     * @var string
     */
    private $post_password;

    /**
     * Database-driven value
     * @var string
     */
    private $post_status;

    /**
     * Database-driven value
     * @var string
     */
    private $post_title;

    /**
     * Database-driven value
     * @var string
     */
    private $post_type;

    /**
     * Database-driven value
     * @var string
     */
    private $tags_input;

    /**
     * Database-driven value
     * @var string
     */
    private $to_ping;

    /**
     * Database-driven value
     * @var string
     */
    private $tax_input;

    /**
     * Database-driven value
     * @var datetime
     */
    private $post_modified;

    /**
     * Database-driven value
     * @var datetime
     */
    private $post_modified_gmt;

    /**
     * Database-driven value
     * @var string
     */
    private $post_content_filtered;

    /**
     * Database-driven value
     * @var string
     */
    private $guid;

    /**
     * Database-driven value
     * @var string
     */
    private $post_mime_type;

    /**
     * Database-driven value
     * @var int
     */
    private $comment_count;

    /**
     * Database-driven value
     * @var string
     */
    private $filter;

    /**
     * If an ID is supplied, this class will try and fetch the post then hydrate the new instance with the details.
     * @param null|int $ID
     * @uses WP_Post
     * @access public
     */
    public function __construct($ID = null)
    {
      if (!is_null($ID)) {
        $post = WP_Post::get_instance($ID);
        if ($post) {
          $this->hydrate($post);
        }
      }
    }

    /**
     * This function will populate the current instance with the post data passed to it by the constructor.
     * @param WP_Post $post
     * @return null
     * @access private
     */
    private function hydrate(WP_Post $post)
    {
      $default_vars = get_class_vars(get_class($this));
      unset($default_vars['meta']);

      $this->meta = array();
      foreach ($post as $key=>$val) {
        if (array_key_exists($key, $default_vars)) {
          $this->$key = $val;
        }
        else {
          $this->meta[$key] = $val;
        }
      }

      return null;
    }

    /**
     * Set the value of a key. If the key does not exist, add the value to the meta array
     * @param string $key
     * @param string $val
     * @return Post $this
     * @access public
     */
    public function set($key, $val)
    {
      if (property_exists($this, $key)) {
        $this->$key = $val;
      }
      else $this->meta[$key] = $val;

      return $this;
    }

    /**
     * Return the value of the given key. If the key does not exist, try and get the value from the meta array.
     * If that doesn't exist, return null.
     * @param string $key
     * @return mixed
     * @access public
     */
    public function get($key = null)
    {
      if (is_null($key)) {
        return get_object_vars($this);
      }

      if (property_exists($this, $key)) {
        return $this->$key;
      }

      return (isset($this->meta[$key])) ? $this->meta[$key] : null;
    }

    /**
     * Save the given post to the database.
     * If no ID is set on the current instance, will attempt to create a post.
     * Otherwise, it will update.
     * @return Post $this
     * @access public
     */
    public function save()
    {
      if ($this->ID) {
        return $this->update();
      }

      // Insert post here.
      $this->ID = wp_insert_post($this->get());
      $this->save_meta();

      return $this;
    }

    /**
     * Delete a given post
     * @return bool
     */
    public function delete()
    {
      if ($this->ID) {
        wp_delete_post($this->ID, true);
        return true;
      }

      return false;
    }

    /**
     * Trash a given post
     * @return bool
     */
    public function trash()
    {
      if ($this->ID) {
        wp_delete_post($this->ID, false);
        return true;
      }

      return false;
    }

    /**
     * Update an existing post.
     * Should only be called from the save() function.
     * @access private
     * @return Post $this
     */
    private function update()
    {
      $this->ID = wp_update_post($this->get());
      $this->save_meta();
      return $this;
    }

    /**
     * Helper function to update all the meta fields on the post
     * @access private
     * @return bool
     */
    private function save_meta()
    {
      if (is_array($this->meta)) {
        foreach ($this->meta as $key=>$val) {
          update_post_meta($this->ID, $key, $val);
        }
      }

      return true;
    }
  }
}