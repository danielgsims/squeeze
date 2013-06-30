<?php

namespace Squeeze1_0
{
  class Mustache extends \Mustache_Engine
  {

    /**
     * __constuct
     * Extends the Mustache_Engine class to set the Views folder path
     * @param string $viewPath
     */
    public function __construct($viewPath = 'App')
    {
      parent::__construct(array(
        'loader' => new \Mustache_Loader_FilesystemLoader(\SQ_PLUGIN_PATH .'/Squeeze1_0/'. $viewPath .'/Views')
      ));
    }

  }

}