<?php

// Our plugin's path.
define('SQ_CORE_PATH', dirname(dirname(__FILE__)));

include_once "SplClassLoader.php";
$classLoader = new Squeeze1_0\SplClassLoader('Squeeze1_0', SQ_CORE_PATH);
$classLoader->register();

$appLoader = new Squeeze1_0\SplClassLoader($options['app_namespace'], $options['app_path']);
$appLoader->register();

if (file_exists(SQ_CORE_PATH .'/Settings.php')) include SQ_CORE_PATH .'/Settings.php';

if (function_exists('\Squeeze1_0\Squeeze1_0_init')) {
  add_action('init', '\Squeeze1_0\Squeeze1_0_init');
}

if (function_exists('\Squeeze1_0\Squeeze1_0_admin_init')) {
  add_action('admin_init', '\Squeeze1_0\Squeeze1_0_admin_init');
}

Squeeze1_0\Bootstrapper::init($options);