<?php

/**
 * Route
 * This is the class that holds everything together.
 * A workable Router will enable true MVC.
 */
namespace Squeeze\Core;

class AdminRouteGroup
{

  private $routes = array();

  public function __construct()
  {}

  public function page(AdminRoutePage $page)
  {
    $this->routes[] = $page;
  }

  public function parseRoutes()
  {
    if (empty($this->routes)) {
      return false;
    }

    foreach ($this->routes as $key=>$route) {
      $menu = new Menu();
      $menu->setPageTitle($route->getPageTitle());
      $menu->setMenuTitle($route->getMenuTitle());
      $menu->setMenuCapability($route->getMenuCapability());
      $menu->setSlug($route->getSlug());
      $menu->setFunction($route->getFunction());

      if ($key !== 0) {
        $menu->setMenuParent($this->routes[0]->getSlug());
      }
      
      $menu->execute();
      // print_R($menu);exit;
    }
  }
}