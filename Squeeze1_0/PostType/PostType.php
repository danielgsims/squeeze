<?php

namespace Squeeze1_0\PostType
{
  use \ICanBoogie\Inflector;

  /**
   * @since 1.0
   */
  class PostType
  {

    /**
     * existingPostTypes
     * This list is maintained to prevent post type collisions
     * @var array
     * @access private
     * @static
     * @since 1.0
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
     * @since 1.0
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
     * @since 1.0
     */
    protected $labels = array();

    /**
     * @since 1.0
     */
    protected $public = true;

    /**
     * @since 1.0
     */
    protected $publicly_queryable = true;

    /**
     * @since 1.0
     */
    protected $show_ui = true;

    /**
     * @since 1.0
     */
    protected $show_in_menu = true;

    /**
     * @since 1.0
     */
    protected $query_var = true;

    /**
     * @since 1.0
     */
    protected $rewrite;

    /**
     * @since 1.0
     */
    protected $capability_type = 'post';

    /**
     * @since 1.0
     */
    protected $has_archive = true;

    /**
     * @since 1.0
     */
    protected $hierarchical = false;

    /**
     * @since 1.0
     */
    protected $menu_position = null;

    /**
     * @since 1.0
     */
    protected $supports = array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' );

    /**
     * @since 1.0
     */
    public function bootstrap($appOptions)
    {
      $this->appOptions = $appOptions;

      $this->executeMetaBox();

      if (!array_key_exists($this->getSlug(), self::$existingPostTypes)) {
        self::$existingPostTypes[$this->getSlug()] = $this->getSlug();

        $this->createLabels();
        $this->setRewrite();

        add_action('init', array($this, 'execute'));
      }
    }

    /**
     * @since 1.0
     */
    private function createLabels()
    {
      $inflector = Inflector::get();
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

    /**
     * @since 1.0
     */
    private function setRewrite()
    {
      if (!$this->rewrite) {
        $this->rewrite = array('slug' => $this->getSlug());
      }
    }

    /**
     * @since 1.0
     */
    public function execute()
    {
      $args = get_object_vars($this);
      register_post_type( $this->getSlug(), $args );
    }

    /**
     * @since 1.0
     */
    public function executeMetaBox()
    {
      if (isset($this->metaBoxes)) {
        foreach ($this->metaBoxes as $metaBox) {
          $this->loadMetaBox($metaBox);
        }
      }
    }

    /**
     * @since 1.0
     */
    private function getSlug()
    {
      $className = get_called_class();
      $className = explode('\\', $className);
      return end($className);
    }

    /**
     * @since 1.0
     */
    private function getLabel()
    {
      return (isset($this->label)) ? $this->label : 'Squeeze';
    }

    /**
     * @since 1.0
     */
    private function loadMetaBox($key)
    {
      $className = $this->appOptions['app_namespace'] .'\App\PostType\MetaBox\\'. $key;

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