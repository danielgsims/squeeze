<?php

namespace Squeeze1_0\ShortCode
{
  use \Squeeze1_0\EnvironmentVariables;

  abstract class ShortCode
  {
    protected $attributes;
    protected $content;

    public final function bootstrap(EnvironmentVariables $env)
    {
      // if (!property_exists($this, 'key')) {
      //   throw new \Exception('$key must be defined');
      // }

      if (property_exists($this, 'enclosing') && !is_bool($this->enclosing)) {
        throw new Exception('$enclosing must be defined as a boolean');
      }

      $this->execute();
    }

    private function execute()
    {
      $obj = $this;
      add_shortcode($this->key, function($attributes, $content = null) use ($obj) {
        if ($obj->enclosing) {
          $obj->content = $content;
        }

        $obj->attributes = shortcode_atts($obj->requiredAttributes, $attributes);

        return $obj->callback();
      });
    }

    public abstract function callback();
  }
}
