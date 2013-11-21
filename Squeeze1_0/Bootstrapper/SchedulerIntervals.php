<?php

namespace Squeeze1_0\Bootstrapper
{
  use \Squeeze1_0\Bootstrapper;
  use \Squeeze1_0\EnvironmentVariables;

  class SchedulerIntervals extends Bootstrapper
  {
    /**
     * @since 1.0
     */
    protected $bootstrapperFolder = 'Scheduler/Interval';

    /**
     * @since 1.0
     */
    protected $scanCoreFolder = false;

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