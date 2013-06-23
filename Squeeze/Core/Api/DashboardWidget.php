<?php

namespace Squeeze\Core\Api;

class DashboardWidget
{
  private $widget_id;
  private $widget_title;
  private $function;
  private $update_function;

  public function setWidgetId($widgetId)
  {
    $this->widget_id = $widgetId;
    return $this;
  }

  public function setWidgetTitle($widgetTitle)
  {
    $this->widget_title = $widgetTitle;
    return $this;
  }

  public function setFunction($function)
  {
    $this->function = $function;
    return $this;
  }

  public function setUpdateFunction($updateFunction)
  {
    $this->update_function = $updateFunction;
    return $this;
  }

  public function execute()
  {
    add_action('wp_dashboard_setup', array($this, 'addDashboardWidget'));
  }

  public function addDashboardWidget()
  {
    wp_add_dashboard_widget($this->widget_id, $this->widget_title, $this->function, $this->update_function);
  }
}