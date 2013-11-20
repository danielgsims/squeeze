<?php

namespace Squeeze1_0\Bootstrapper
{
  use \Squeeze1_0\Bootstrapper;

  class CronIntervals extends Bootstrapper
  {
    public $ignore = true;
    /**
     * @since 1.0
     */
    protected $bootstrapperFolder = 'Scheduler/Interval';

    /**
     * @since 1.0
     */
    protected $scanCoreFolder = true;

    /**
     * @since 1.0
     */
    private $loadedCronIntervals = array();

    /**
     * @since 1.0
     */
    private $cronIntervals = array();
  }
}