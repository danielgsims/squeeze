<?php

namespace Squeeze\Core;

class AdminRoutePage
{
  /**
   * @var string
   * @access private
   */
  private $slug;

  /**
   * @var string
   * @access private
   */
  private $menu_parent;

  /**
   * @var string
   * @access private
   */
  private $page_title;

  /**
   * @var string
   * @access private
   */
  private $menu_title;

  /**
   * @var string
   * @access private
   */
  private $menu_capability;

  /**
   * @var callback
   * @access private
   */
  private $function;

  /**
   * @var string
   * @access private
   */
  private $controller_name;

  /**
   * @var string
   * @access private
   */
  private $controller_method;

  /**
   * @var string
   * @access private
   */
  private $menu_icon;

  /**
   * @var int
   * @access private
   */
  private $menu_priority = 99;

  /**
   * __construct
   * @access public
   * @param string $slug
   * @param array $args
   */
  public function __construct($slug, $args)
  {
    $this->slug = $slug;
    foreach ($args as $key=>$val) {
      if (property_exists($this, $key)) {
        $this->$key = $val;
      }

      if (!isset($args['controller_name'])) {
        $name = String::firstCharUpperCase($this->slug);
        $this->controller_name = $name;
      }

      if (!isset($args['controller_method'])) {
        $this->controller_method = 'index';
      }
    }
  }

  public function getSlug()
  {
    return $this->slug;
  }

  public function getMenuParent()
  {
    return $this->menu_parent;
  }

  public function getPageTitle()
  {
    return $this->page_title;
  }

  public function getMenuTitle()
  {
    return $this->menu_title;
  }

  public function getMenuCapability()
  {
    return $this->menu_capability;
  }

  public function getFunction()
  {
    if (!$this->function) {
      $controllerName = '\Squeeze\App\Controller\\'. $this->getControllerName();
      $controller = new $controllerName;
      return array($controller, $this->getControllerMethod());
    }

    return $this->function;
  }

  public function getMenuIcon()
  {
    return $this->menu_icon;
  }

  public function getMenuPriority()
  {
    return $this->menu_priority;
  }

  public function getControllerName()
  {
    return $this->controller_name;
  }

  public function getControllerMethod()
  {
    return $this->controller_method;
  }
}