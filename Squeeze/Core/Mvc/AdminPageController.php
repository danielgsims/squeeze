<?php

namespace Squeeze\Core\Mvc;

class AdminPageController
{
  public function __construct()
  {}

  public function pre()
  {}

  public function bootstrap()
  {
    $adminMenuItem = new \Squeeze\Core\Api\Menu();
    $adminMenuItem->setPageTitle($this->getPageTitle());
    $adminMenuItem->setMenuTitle($this->getMenuTitle());
    $adminMenuItem->setMenuCapability($this->getCapability());
    $adminMenuItem->setFunction(array($this, 'index'));
    $adminMenuItem->setSlug($this->getSlug());

    if (isset($this->parent)) {
      $adminMenuItem->setMenuParent($this->getMenuParent());
    }

    $adminMenuItem->execute();
  }

  private function getPageTitle()
  {
    if (isset($this->page_title)) {
      return $this->page_title;
    }

    if (isset($this->menu_title)) {
      return $this->menu_title;
    }

    else return 'Squeeze Page';
  }

  private function getMenuTitle()
  {
    if (isset($this->menu_title)) {
      return $this->menu_title;
    }

    if (isset($this->page_title)) {
      return $this->page_title;
    }

    return 'Squeeze Page';
  }

  private function getCapability()
  {
    if (isset($this->capability)) {
      return $this->capability;
    }

    return 'manage_options';
  }

  private function getSlug()
  {
    $className = get_called_class();
    $className = explode('\\', $className);
    return end($className);
  }

  private function getMenuParent()
  {
    return (isset($this->parent)) ? $this->parent : '';
  }
}