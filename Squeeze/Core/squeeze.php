<?php

// Our plugin's path.
define('SQ_PLUGIN_PATH', dirname(dirname(dirname(__FILE__))));

include "SplClassLoader.php";
$classLoader = new Squeeze\Core\SplClassLoader('Squeeze', SQ_PLUGIN_PATH);
$classLoader->register();

// if(file_exists(SQ_PLUGIN_PATH .'/Routes.php')) include SQ_PLUGIN_PATH .'/Routes.php';
if(file_exists(SQ_PLUGIN_PATH .'/Settings.php')) include SQ_PLUGIN_PATH .'/Settings.php';


if (function_exists('\Squeeze\squeeze_init')) {
  add_action('init', '\Squeeze\squeeze_init');
}

if (function_exists('\Squeeze\squeeze_admin_init')) {
  add_action('admin_init', '\Squeeze\squeeze_admin_init');
}

Squeeze\Core\Bootstrapper::init();