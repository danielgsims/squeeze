<?php

namespace Squeeze1_0\Controller
{

  /**
   * The base controller for implementing WordPress Admin Pages
   * @abstract
   * @since 1.0
   */
  abstract class AdminPageController implements \Squeeze1_0\Implementable\iController
  {
    /**
     * An array containing the current application options.
     *
     * Injected into the `bootstrap()` method by the core bootstrapper class.
     * @var array
     * @since 1.0
     */
    protected $appOptions = array();

    /**
     * Base constructor.
     *
     * May be extended by the implementation
     * @since 1.0
     */
    public function __construct()
    {}

    /**
     * A function that is called prior to anything else in the controller.
     *
     * Useful for injecting additional hooks and such
     * @since 1.0
     */
    public function pre()
    {}

    /**
     * The main callback function page.
     *
     * Must be defined by all implementations.
     * @since 1.0
     */
    public abstract function index();

    /**
     * The bootstrap function.
     *
     * This function will do the legwork of actually creating the page.
     * @final
     * @param array $appOptions
     * @return void
     * @uses \Squeeze1_0\Api\Menu
     * @since 1.0
     */
    public final function bootstrap($appOptions)
    {
      $this->appOptions = $appOptions;

      $adminMenuItem = new \Squeeze1_0\Api\Menu();
      $adminMenuItem->setPageTitle($this->getTitle());
      $adminMenuItem->setMenuTitle($this->getMenuTitle());
      $adminMenuItem->setMenuCapability($this->getCapability());
      $adminMenuItem->setFunction(array($this, 'index'));
      $adminMenuItem->setSlug($this->getSlug());

      if (isset($this->parent)) {
        $adminMenuItem->setMenuParent($this->getMenuParent());
      }

      $adminMenuItem->execute();
    }

    /**
     * A private, un-overridable function to fetch the page slug from the implementation.
     *
     * Squeeze uses the class names as slugs.
     * @return string
     * @final
     * @since 1.0
     */
    private final function getSlug()
    {
      $className = get_called_class();
      $className = explode('\\', $className);
      return end($className);
    }

    /**
     * A private, un-overridable function to fetch the page title from the implementation.
     *
     * If it is not defined, we'll return a default value.
     * @return string
     * @final
     * @since 1.0
     */
    private final function getTitle()
    {
      if (isset($this->title)) {
        return $this->title;
      }

      if (isset($this->menu_title)) {
        return $this->menu_title;
      }

      else return 'Squeeze 1.0 Page';
    }

    /**
     * A private, un-overridable function to fetch the menu title from the implementation.
     *
     * If it is not defined, we'll return a default value.
     * @return string
     * @final
     * @since 1.0
     */
    private final function getMenuTitle()
    {
      if (isset($this->menu_title)) {
        return $this->menu_title;
      }

      if (isset($this->title)) {
        return $this->title;
      }

      return 'Squeeze 1.0 Page';
    }

    /**
     * A private, un-overridable function to fetch the user capability from the implementation.
     *
     * If it is not defined, we'll return a default value.
     *
     * Define in your controller by adding a protected property called `$capability`.
     * @return string
     * @final
     * @since 1.0
     */
    private final function getCapability()
    {
      if (isset($this->capability)) {
        return $this->capability;
      }

      return 'manage_options';
    }

    /**
     * A private, un-overridable function to fetch the menu parent from the implementation.
     *
     * If this is not defined in your controller, it will be created as a root-level page.
     *
     * Set the parent by adding a protected property called `$parent`.
     * @return string
     * @final
     * @since 1.0
     */
    private final function getMenuParent()
    {
      return (isset($this->parent)) ? $this->parent : '';
    }
  }
}