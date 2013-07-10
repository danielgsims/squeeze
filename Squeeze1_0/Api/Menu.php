<?php

namespace Squeeze1_0\Api;

/**
 * Menu class
 * Create WordPress navigation menus
 */
class Menu
{
  private static $registered_menus = array();

  private static $enqueued_menus = array();

  private $default_menus = array(
    'dashboard' => 'add_dashboard_menu',
    'posts' => 'add_posts_page',
    'media' => 'add_media_page',
    'links' => 'add_links_page',
    'pages' => 'add_pages_page',
    'comments' => 'add_comments_page',
    'appearance' => 'add_theme_page',
    'plugins' => 'add_plugins_page',
    'users' => 'add_users_page',
    'tools' => 'add_management_page',
    'settings' => 'add_options_page',
  );

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
   * @var string
   * @access private
   */
  private $slug;

  /**
   * @var callback
   * @access private
   */
  private $function;

  /**
   * @var string
   * @access private
   */
  private $menu_icon;

  /**
   * @var int
   * @access private
   */
  private $menu_priority;

  /**
   * setMenuParent
   * @access public
   * @param string $menuParent
   * @return Menu $this
   */
  public function setMenuParent($menuParent)
  {
    $this->menu_parent = $menuParent;
    return $this;
  }

  /**
   * setPageTitle
   * @access public
   * @param string $pageTitle
   * @return Menu $this
   */
  public function setPageTitle($pageTitle)
  {
    $this->page_title = $pageTitle;
    return $this;
  }

  /**
   * setMenuTitle
   * @access public
   * @param string $menuTitle
   * @return Menu $this
   */
  public function setMenuTitle($menuTitle)
  {
    $this->menu_title = $menuTitle;
    return $this;
  }

  /**
   * setMenuCapability
   * @access public
   * @param string $menuCapability
   * @return Menu $this
   */
  public function setMenuCapability($menuCapability)
  {
    $this->menu_capability = $menuCapability;
    return $this;
  }

  /**
   * setSlug
   * @access public
   * @param string $slug
   * @return Menu $this
   */
  public function setSlug($slug)
  {
    $this->slug = $slug;
    return $this;
  }

  /**
   * setFunction
   * @access public
   * @param callback $function
   * @return Menu $this
   */
  public function setFunction($function)
  {
    $this->function = $function;
    return $this;
  }

  /**
   * execute
   * Once we've set all the required menu parameters, register the menu page.
   * WordPress won't create a submenu item with a parent that hasn't been declared yet.
   * To get around this, we're creating a static registry of declared menus.
   * If a menu hasn't been declared yet, we'll save an instance of the Menu object.
   * When a top-level menu is created, we'll check to see if there are any enqueued submenus.
   * If so, we'll create them at that point.
   * @access public
   * @return null
   */
  public function execute($retry = false)
  {
    self::$registered_menus[] = $this->slug;
    if ($this->menu_parent) {
      if (!in_array($this->menu_parent, self::$registered_menus) && !array_key_exists($this->menu_parent, $this->default_menus)) {
        self::$enqueued_menus[$this->menu_parent][] = $this;
        return;
      }
    }
    add_action( 'admin_menu', array($this, 'register_menu_page') );
  }

  /**
   * register_menu_page
   * This is public to allow WordPress to access it. Don't call this directly.
   * @access public
   * @return null
   */
  public function register_menu_page()
  {
    if ($this->menu_parent) {
      if (array_key_exists($this->menu_parent, $this->default_menus)) {
        call_user_func_array($this->default_menus[$this->menu_parent], array(
          $this->page_title,
          $this->menu_title,
          $this->menu_capability,
          $this->slug,
          $this->function
        ));
      }
      else {
        add_submenu_page( $this->menu_parent, $this->page_title, $this->menu_title, $this->menu_capability, $this->slug, $this->function );
      }
    }
    else {
      add_menu_page( $this->page_title, $this->menu_title, $this->menu_capability, $this->slug, $this->function, $this->menu_icon, $this->menu_priority );

      if(array_key_exists($this->slug, self::$enqueued_menus)) {
        foreach(self::$enqueued_menus[$this->slug] as $submenu) {
          $submenu->register_menu_page();
        }

        unset(self::$enqueued_menus[$this->slug]);
      }
    }
  }
}