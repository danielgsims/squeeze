<?php

namespace Squeeze1_0\PostType\MetaBox
{
  /**
   * @since 1.0
   */
  class MetaBox
  {
    /**
     * @since 1.0
     */
    private $title = 'Squeeze';

    /**
     * @since 1.0
     */
    private $context = 'normal';

    /**
     * @since 1.0
     */
    private $priority = 'low';

    /**
     * @since 1.0
     */
    private $callback_args = array();

    /**
     * @since 1.0
     */
    public function getSlug()
    {
      $className = get_called_class();
      $className = explode('\\', $className);
      return end($className);
    }

    /**
     * @since 1.0
     */
    public function getTitle()
    {
      return $this->title;
    }

    /**
     * @since 1.0
     */
    public function getContext()
    {
      return $this->context;
    }

    /**
     * @since 1.0
     */
    public function getPriority()
    {
      return $this->priority;
    }

    /**
     * @since 1.0
     */
    public function getCallback()
    {
      if (!method_exists($this, 'content')) {
        return function() { echo "Hello World"; };
      }

      return array($this, 'content');
    }

    /**
     * @since 1.0
     */
    public function getCallbackArgs()
    {
      return $this->callback_args;
    }

    /**
     * @since 1.0
     */
    public function execute($postType)
    {
      add_meta_box(
        $this->getSlug(),
        $this->getTitle(),
        $this->getCallback(),
        $postType,
        $this->getContext(),
        $this->getPriority(),
        $this->getCallbackArgs()
      );
    }
  }
}