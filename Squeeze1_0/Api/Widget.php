<?php

namespace Squeeze1_0\Api
{
  use WP_Widget;
  use Squeeze1_0\Implementable\iWidget;

  /**
   * An automatically bootstrapped implementation of WP_Widget.
   * @since 1.0
   */
  class Widget extends WP_Widget implements iWidget
  {

    /**
     * @since 1.0
     */
    public function __construct()
    {
      parent::__construct(
        $this->getSlug(),
        $this->getName(),
        array(
          'description' => $this->getDescription()
        )
      );
    }

    /**
     * @since 1.0
     */
    public function bootstrap()
    {
      add_action( 'widgets_init', function(){
        register_widget(get_called_class());
      });
    }

    /**
     * A private, un-overridable function to fetch the widget slug from the implementation.
     *
     * Squeeze uses the class names as slugs.
     * @return string
     * @final
     * @since 1.0
     */
    private final function getSlug()
    {
      $className = get_called_class();
      $className = explode('\\', $className);
      return end($className);
    }

    /**
     * @since 1.0
     */
    private final function getName()
    {
      return (isset($this->name) ? $this->name : 'Squeeze');
    }

    /**
     * @since 1.0
     */
    private final function getDescription()
    {
      return (isset($this->description)) ? $this->description : 'A Widget made with Squeeze';
    }
  }
}