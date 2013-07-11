<?php

namespace Squeeze1_0\Controller
{

  /**
   * The base controller for implementing WordPress Admin Pages
   *
   * This feature has not yet been implemented.
   * @abstract
   */
  abstract class PageController implements \Squeeze1_0\Implementable\iController
  {
    /**
     * An array containing the current application options.
     *
     * Injected into the `bootstrap()` method by the core bootstrapper class.
     * @var array
     */
    protected $appOptions = array();

    /**
     * Base constructor.
     *
     * May be extended by the implementation
     */
    public function __construct()
    {}

    /**
     * A function that is called prior to anything else in the controller.
     *
     * Useful for injecting additional hooks and such
     */
    public function pre()
    {}

    /**
     * The main callback function page.
     *
     * Must be defined by all implementations.
     */
    public abstract function index();

    /**
     * The bootstrap function.
     *
     * This function will do the legwork of actually creating the page.
     * @final
     * @param array $appOptions
     * @return void
     */
    public function bootstrap($appOptions)
    {
      $this->appOptions = $appOptions;
    }
  }
}