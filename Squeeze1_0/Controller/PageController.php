<?php

namespace Squeeze1_0\Controller
{

  use Squeeze1_0\Implementable\iController;

  /**
   * The base controller for implementing WordPress Admin Pages
   *
   * This feature has not yet been implemented.
   * @abstract
   * @since 1.0
   */
  abstract class PageController implements iController
  {
    /**
     * An array containing the current application options.
     *
     * Injected into the `bootstrap()` method by the core bootstrapper class.
     * @var array
     * @since 1.0
     */
    protected $appOptions = array();

    /**
     * Base constructor.
     *
     * May be extended by the implementation
     * @since 1.0
     */
    public function __construct()
    {}

    /**
     * A function that is called prior to anything else in the controller.
     *
     * Useful for injecting additional hooks and such
     * @since 1.0
     */
    public function pre()
    {}

    /**
     * The main callback function page.
     *
     * Must be defined by all implementations.
     * @since 1.0
     */
    public abstract function index();

    /**
     * The bootstrap function.
     *
     * This function will do the legwork of actually creating the page.
     * @final
     * @param array $appOptions
     * @return void
     * @since 1.0
     */
    public function bootstrap($appOptions)
    {
      $this->appOptions = $appOptions;
    }
  }
}