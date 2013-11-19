<?php

namespace Squeeze1_0\PostType\Taxonomy
{
  use \Squeeze1_0\Util\LabelMaker;

  abstract class Taxonomy extends LabelMaker
  {
    /**
     * existingTaxonomies
     * This list is maintained to prevent type collisions
     * @var array
     * @access private
     * @static
     * @since 1.0
     */
    private static $existingTaxonomies = array(
      'Category' => 'category',
      'Tag' => 'tag',
      'LinkCategory' => 'link_category'
    );

    /**
     * defaultLabels
     * The default labels and whether they are plural or singular.
     * @var array
     * @access private
     * @since 1.0
     */
    protected $defaultLabels = array(
      'name' => array(
        'inflection' => 'plural',
        'value' => '%s'
      ),
      'singular_name' => array(
        'inflection' => 'singular',
        'value' => '%s'
      ),
      'menu_name' => array(
        'inflection' => 'plural',
        'value' => '%s'
      ),
      'add_new_item' => array(
        'inflection' => 'singular',
        'value' => 'Add New %s'
      ),
      'new_item_name' => array(
        'inflection' => 'singular',
        'value' => 'New %s Name'
      ),
      'update_item' => array(
        'inflection' => 'singular',
        'value' => 'Update %s'
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
      'parent_item' => array(
        'inflection' => 'singular',
        'value' => 'Parent %s'
      ),
      'parent_item_colon' => array(
        'inflection' => 'singular',
        'value' => 'Parent %s:'
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

    protected $label;

    /**
     * @since 1.0
     */
    protected $hierarchical = true;

    /**
     * @since 1.0
     */
    protected $show_ui = true;

    /**
     * @since 1.0
     */
    protected $show_admin_column = true;

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
    private function getSlug()
    {
      $className = get_called_class();
      $className = explode('\\', $className);
      return end($className);
    }

    /**
     * @since 1.0
     */
    public function execute($postType)
    {
      $this->createLabels();

      $args = array();
      foreach (get_object_vars($this) as $key=>$val) {
        $args[$key] = $val;
      }

      register_taxonomy(strtolower($this->getSlug()), 'bankers', $args);
    }
  }
}