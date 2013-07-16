<?php

namespace Squeeze1_0\Api
{

  /**
   * Create Admin Dashboard Widgets.
   * This class is a simple API for hooking into the WordPress page.
   * It's implemented in core in `Mvc\DashboardWidget`.
   * @since 1.0
   */
  class DashboardWidget
  {

    /**
     * @since 1.0
     */
    private $widget_slug;

    /**
     * @since 1.0
     */
    private $widget_title;

    /**
     * @since 1.0
     */
    private $function;

    /**
     * @since 1.0
     */
    private $update_function;

    /**
     * @return \Squeeze1_0\Api\DashboardWidget
     * @since 1.0
     */
    public function setWidgetSlug($widgetSlug)
    {
      $this->widget_slug = $widgetSlug;
      return $this;
    }

    /**
     * @return \Squeeze1_0\Api\DashboardWidget
     * @since 1.0
     */
    public function setWidgetTitle($widgetTitle)
    {
      $this->widget_title = $widgetTitle;
      return $this;
    }

    /**
     * @return \Squeeze1_0\Api\DashboardWidget
     * @since 1.0
     */
    public function setFunction($function)
    {
      $this->function = $function;
      return $this;
    }

    /**
     * @return \Squeeze1_0\Api\DashboardWidget
     * @since 1.0
     */
    public function setUpdateFunction($updateFunction)
    {
      $this->update_function = $updateFunction;
      return $this;
    }

    /**
     * Invoke the WordPress hook.
     * @final
     * @return void
     * @since 1.0
     */
    public final function execute()
    {
      add_action('wp_dashboard_setup', array($this, 'addDashboardWidget'));
    }

    /**
     * **Do not call this function directly.**
     * Should be accessed via the `execute()` method.
     * @final
     * @return void
     * @since 1.0
     */
    public final function addDashboardWidget()
    {
      wp_add_dashboard_widget($this->widget_slug, $this->widget_title, $this->function, $this->update_function);
    }
  }
}