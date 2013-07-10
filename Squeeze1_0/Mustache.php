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
    public function __construct($viewPath = null)
    {
      if (is_null($viewPath)) {
        $viewPath = \SQ_CORE_PATH .'/Squeeze1_0/Views';
      }

      parent::__construct(array(
        'loader' => new \Mustache_Loader_FilesystemLoader($viewPath)
      ));
    }

  }

}