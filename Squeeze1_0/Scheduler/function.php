<?php

// WordPress does not allow scheduled jobs to be hooked to an object.
// So this function is the friendly little hook we use to work around that problem.
add_action('squeeze1_0_scheduler', 'squeeze1_0_scheduler', 10, 4);
function squeeze1_0_scheduler($start_time, $interval, $FQCN, $method)
{
  // throw new Exception('hello world');
  $class = $FQCN;
  $class = new $class;
  $class->$method();
}