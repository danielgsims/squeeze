<?php

namespace Squeeze1_0\Controller
{

  use \Squeeze1_0\Implementable\iController;
  use \Squeeze1_0\Api\DashboardWidget;

  /**
   * The base controller for creating Admin Dashboard Widgets.
   *
   * Extend this in your app.
   * @since 1.0
   */
  abstract class DashboardWidget implements iController
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
     * This function will do the legwork of actually creating the widget.
     * @final
     * @param array $appOptions
     * @return void
     * @uses \Squeeze1_0\Api\DashboardWidget
     * @since 1.0
     */
    public final function bootstrap($appOptions)
    {
      $this->appOptions = $appOptions;

      $dashboardWidget = new DashboardWidget;
      $dashboardWidget->setWidgetSlug($this->getSlug());
      $dashboardWidget->setWidgetTitle($this->getTitle());
      $dashboardWidget->setFunction(array($this, 'index'));
      $dashboardWidget->setUpdateFunction($this->getUpdateFunction());
      $dashboardWidget->execute();
    }

    /**
     * A private, un-overridable function to fetch the widget slug from the implementation.
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
     * A private, un-overridable function to fetch the widget title from the implementation.
     *
     * If it is not defined, we'll return a default value.
     * @return string
     * @final
     * @since 1.0
     */
    private final function getTitle()
    {
      if(isset($this->title)) return $this->title;

      return 'Squeeze1_0 Widget';
    }

    /**
     * A private, un-overridable function to fetch the update method from the implementation.
     *
     * If it is not defined, no posted values will be saved.
     *
     * To define, create a public method called `updateCallback` in your implementation.
     * @return string
     * @final
     * @since 1.0
     */
    private final function getUpdateFunction()
    {
      if (method_exists($this, 'updateCallback')) {
        return array($this, 'updateCallback');
      }

      return null;
    }
  }
}