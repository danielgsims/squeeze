<?php

if(!defined('SQ_CORE_PATH')) define('SQ_CORE_PATH', dirname(dirname(__FILE__)));
include_once SQ_CORE_PATH .'/Squeeze1_0/Scheduler/function.php';
return function($appOptions) {
  include_once "SplClassLoader.php";
  $classLoader = new Squeeze1_0\SplClassLoader('Squeeze1_0', SQ_CORE_PATH);
  $classLoader->register();

  $appLoader = new Squeeze1_0\SplClassLoader($appOptions['app_namespace'], $appOptions['app_path']);
  $appLoader->register();

  if (file_exists(SQ_CORE_PATH .'/Settings.php')) include SQ_CORE_PATH .'/Settings.php';

  Squeeze1_0\Bootstrapper::init($appOptions);
};