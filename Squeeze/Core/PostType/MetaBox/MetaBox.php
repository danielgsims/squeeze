<?php

namespace Squeeze\Core\PostType\MetaBox
{
  class MetaBox
  {
    private $title = 'Squeeze';
    private $context = 'normal';
    private $priority = 'low';
    private $callback_args = array();

    public function getSlug()
    {
      $className = get_called_class();
      $className = explode('\\', $className);
      return end($className);
    }

    public function getTitle()
    {
      return $this->title;
    }

    public function getContext()
    {
      return $this->context;
    }

    public function getPriority()
    {
      return $this->priority;
    }

    public function getCallback()
    {
      if (!method_exists($this, 'content')) {
        return function() { echo "Hello World"; };
      }

      return array($this, 'content');
    }

    public function getCallbackArgs()
    {
      return $this->callback_args;
    }

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