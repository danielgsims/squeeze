<?php

namespace Squeeze1_0\Bootstrapper
{
  use Squeeze1_0\EnvironmentVariables;
  use Squeeze1_0\Bootstrapper;
  use Squeeze1_0\Scheduler\Job;

  class SchedulerJobs extends Bootstrapper
  {

    /**
     * @since 1.0
     */
    public $ignore = true;

    /**
     * @since 1.0
     */
    private $schedulerFunction = 'squeeze1_0_scheduler';

    /**
     * @since 1.0
     */
    protected $bootstrapperFolder = 'Scheduler/Job';

    /**
     * @since 1.0
     */
    protected $scanCoreFolder = false;

    public function bootstrap(EnvironmentVariables $env = null)
    {
      parent::bootstrap($env);

      foreach (Job::getEnqueuedJobs() as $job) {
        wp_schedule_event($job['start_time'], $job['interval'], $this->schedulerFunction, $job);
      }
    }

    public function unschedule(EnvironmentVariables $env = null)
    {
      parent::bootstrap($env);

      foreach (Job::getEnqueuedJobs() as $job) {
        wp_clear_scheduled_hook($this->schedulerFunction, $job);
      }
    }
  }
}