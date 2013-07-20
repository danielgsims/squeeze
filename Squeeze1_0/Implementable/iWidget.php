<?php

namespace Squeeze1_0\Implementable
{
  interface iWidget
  {
    public function __construct();

    public function widget($args, $instance);

    public function form($instance);

    public function update($new_instance, $old_instance);
  }
}