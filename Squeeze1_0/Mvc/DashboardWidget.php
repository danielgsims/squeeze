<?php

namespace Squeeze1_0\Mvc;

// This isn't implemented yet.
class DashboardWidget
{
  public function pre()
  {}

  public function bootstrap()
  {
    $dashboardWidget = new \Squeeze1_0\Api\DashboardWidget;
    $dashboardWidget->setWidgetId($this->getSlug());
    $dashboardWidget->setWidgetTitle($this->getTitle());
    $dashboardWidget->setFunction(array($this, 'index'));
    $dashboardWidget->setUpdateFunction($this->getUpdateFunction());
    $dashboardWidget->execute();
  }

  private function getSlug()
  {
    $className = get_called_class();
    $className = explode('\\', $className);
    return end($className);
  }

  private function getTitle()
  {
    if(isset($this->title)) return $this->title;

    return 'Squeeze1_0 Widget';
  }

  private function getUpdateFunction()
  {
    if (method_exists($this, 'updateCallback')) {
      return array($this, 'updateCallback');
    }

    return null;
  }
}