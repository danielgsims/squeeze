<?php

namespace Squeeze1_0\Mvc;

interface iWidgetController
{
  public function widget( $args, $instance );

  public function form( $instance );

  public function update( $new_instance, $old_instance );
}