<?php

namespace Squeeze\Core\PostType
{
  class PostType
  {

    /**
     * existingPostTypes
     * This list is maintained to prevent post type collisions
     * @var array
     * @access private
     * @static
     */
    private static $existingPostTypes = array(
      'Post' => 'post',
      'Page' => 'page',
      'Attachment' => 'attachment',
      'Revision' => 'revision',
      'NavMenu' => 'nav_menu_item',
      'Action' => null
    );

    /**
     * default_labels
     * The default labels and whether they are plural or singular.
     * @var array
     * @access private
     */
    private $default_labels = array(
      'name' => array(
        'inflection' => 'plural',
        'value' => '%s'
      ),
      'singular_name' => array(
        'inflection' => 'singular',
        'value' => '%s'
      ),
      'add_new' => array(
        'value' => 'Add New'
      ),
      'add_new_item' => array(
        'inflection' => 'singular',
        'value' => 'Add New %s'
      ),
      'edit_item' => array(
        'inflection' => 'singular',
        'value' => 'Edit %s'
      ),
      'new_item' => array(
        'inflection' => 'singular',
        'value' => 'New %s'
      ),
      'all_items' => array(
        'inflection' => 'plural',
        'value' => 'All %s',
      ),
      'view_item' => array(
        'value' => 'View %s'
      ),
      'search_items' => array(
        'inflection' => 'plural',
        'value' => 'Search %s'
      ),
      'not_found' =>  array(
        'inflection' => 'plural',
        'value' => 'No %s found'
      ),
      'not_found_in_trash' => array(
        'inflection' => 'plural',
        'value' => 'No %s found in Trash'
      ),
      'parent_item_colon' => array(
        'value' => ''
      ),
      'menu_name' => array(
        'inflection' => 'plural',
        'value' => '%s'
      )
    );

    /**
     * labels
     * The parsed labels for the post type.
     * @var array
     * @access protected
     */
    protected $labels = array();

    protected $public = true;
    protected $publicly_queryable = true;
    protected $show_ui = true;
    protected $show_in_menu = true;
    protected $query_var = true;
    protected $rewrite;
    protected $capability_type = 'post';
    protected $has_archive = true;
    protected $hierarchical = false;
    protected $menu_position = null;
    protected $supports = array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' );

    public function bootstrap()
    {
      $this->executeMetaBox();

      if (!array_key_exists($this->getSlug(), self::$existingPostTypes)) {
        self::$existingPostTypes[$this->getSlug()] = $this->getSlug();

        $this->createLabels();
        $this->setRewrite();

        add_action('init', array($this, 'execute'));
      }
    }

    private function createLabels()
    {
      $inflector = \ICanBoogie\Inflector::get();
      $label = array(
        'singular' => $inflector->singularize($this->getLabel()),
        'plural' => $inflector->pluralize($this->getLabel())
      );

      foreach ($this->default_labels as $key => $val) {
        if (!array_key_exists($key, $this->labels)) {
          $this->labels[$key] = sprintf($val['value'], $label[$val['inflection']]);
        }
      }
    }

    private function setRewrite()
    {
      if (!$this->rewrite) {
        $this->rewrite = array('slug' => $this->getSlug());
      }
    }

    public function execute()
    {
      $args = get_object_vars($this);
      register_post_type( $this->getSlug(), $args );
    }

    public function executeMetaBox()
    {
      if (isset($this->metaBoxes)) {
        foreach ($this->metaBoxes as $metaBox) {
          $this->loadMetaBox($metaBox);
        }
      }
    }

    private function getSlug()
    {
      $className = get_called_class();
      $className = explode('\\', $className);
      return end($className);
    }

    private function getLabel()
    {
      return (isset($this->label)) ? $this->label : 'Squeeze';
    }

    private function loadMetaBox($key)
    {
      $className = '\Squeeze\App\PostType\MetaBox\\'. $key;

      if (class_exists($className)) {
        $metaBox = new $className;

        add_action('add_meta_boxes', array($metaBox, 'execute'), $this->getSlug(), 1);

        if (method_exists($metaBox, 'save')) {
          add_action('save_post', array($metaBox, 'save'));
        }
      }
    }
  }
}