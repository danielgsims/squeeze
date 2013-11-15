<?php

namespace Squeeze1_0\Bootstrappers
{
  use \Squeeze1_0\Bootstrapper;

  class PostTypes extends Bootstrapper
  {
    /**
     * @since 1.0
     */
    private $loadedPostTypes = array();

    /**
     * @since 1.0
     */
    private $postTypes = array();

    /**
     * @since 1.0
     */
    public function bootstrap($appOptions)
    {
      foreach ($this->listFilesInDirectory($appOptions, 'App/PostType') as $bootstrapper) {
        if(class_exists($bootstrapper['FQCN'])) {
          $this->loadedPostTypes[$bootstrapper['FQCN']] = new $bootstrapper['FQCN'];
          $this->loadedPostTypes[$bootstrapper['FQCN']]->bootstrap($appOptions);
        }
      }
    }
  }
}