<?php

namespace Squeeze1_0\Bootstrappers
{
  use \Squeeze1_0\Bootstrapper;
  use \Squeeze1_0\EnvironmentVariables;

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
    public function bootstrap(EnvironmentVariables $env = null)
    {
      foreach ($this->listFilesInDirectory($env, 'PostType') as $bootstrapper) {
        if(class_exists($bootstrapper['FQCN'])) {
          $this->loadedPostTypes[$bootstrapper['FQCN']] = new $bootstrapper['FQCN'];
          $this->loadedPostTypes[$bootstrapper['FQCN']]->bootstrap($env);
        }
      }
    }
  }
}