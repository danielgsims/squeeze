<?php

namespace Squeeze1_0\Api
{

  /**
   * Create Admin Dashboard Widgets.
   * This class is a simple API for hooking into the WordPress page.
   * It's implemented in core in `Mvc\DashboardWidget`.
   */
  class DashboardWidget
  {

    private $widget_slug;
    private $widget_title;
    private $function;
    private $update_function;

    /**
     * @return \Squeeze1_0\Api\DashboardWidget
     */
    public function setWidgetSlug($widgetSlug)
    {
      $this->widget_slug = $widgetSlug;
      return $this;
    }

    /**
     * @return \Squeeze1_0\Api\DashboardWidget
     */
    public function setWidgetTitle($widgetTitle)
    {
      $this->widget_title = $widgetTitle;
      return $this;
    }

    /**
     * @return \Squeeze1_0\Api\DashboardWidget
     */
    public function setFunction($function)
    {
      $this->function = $function;
      return $this;
    }

    /**
     * @return \Squeeze1_0\Api\DashboardWidget
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
     */
    public final function addDashboardWidget()
    {
      wp_add_dashboard_widget($this->widget_slug, $this->widget_title, $this->function, $this->update_function);
    }
  }
}