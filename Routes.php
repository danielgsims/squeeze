<?php

namespace Squeeze;

$testRouteGroup = new Core\Router\AdminRouteGroup;

$testRouteGroup->page(new Core\Router\AdminRoutePage('testPage', array(
  'page_title' => 'Test Page',
  'menu_title' => 'Test Page',
  'menu_capability' => 'manage_options',
)));

$testRouteGroup->page(new Core\Router\AdminRoutePage('testPage2', array(
  'page_title' => 'Test Page 2',
  'menu_title' => 'Test Page 2',
  'menu_capability' => 'manage_options',
  'controller_name' => 'testPage',
  'controller_method' => 'sub_page'
)));

$testRouteGroup->parseRoutes();