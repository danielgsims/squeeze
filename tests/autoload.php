<?php

include "./Squeeze1_0/SplClassLoader.php";

if(!defined('SQ_CORE_PATH')) define('SQ_CORE_PATH', dirname(dirname(__FILE__)));
$classLoader = new Squeeze1_0\SplClassLoader('Squeeze1_0', SQ_CORE_PATH);
$classLoader->register();