<?php

namespace Squeeze\Core {

  class Activation
  {

    private static $instance;

    public static function instance()
    {
      if (!is_a(self::$instance, self)) {
        self::$instance = new self;
      }

      return self::$instance;
    }

    public function activation()
    {}

  }

}