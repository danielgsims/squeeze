<?php

return function($args) {
  $version = $args['squeeze_version'];
  $versionDirectory = 'Squeeze'. str_replace('.', '_', $version);

  $initFunction = include $versionDirectory .'/init.php';
  return $initFunction($args);
};