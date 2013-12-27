<?php

namespace Squeeze1_0\ShortCode
{
  use \Squeeze1_0\EnvironmentVariables;

  abstract class ShortCode
  {
    protected $attributes;

    public final function bootstrap(EnvironmentVariables $env)
    {
      if (!property_exists($this, 'key')) {
        throw new \Exception('$key must be defined');
      }

      $this->execute();
    }

    private function execute()
    {
      add_shortcode($this->key, function($attributes) {
        $this->attributes = shortcode_atts($this->requiredAttributes, $attributes);

        return $this->callback();
      });
    }

    public abstract function callback();
  }
}
