<?php

namespace Squeeze1_0\Api
{
  use Squeeze1_0\EnvironmentVariables;
  use Squeeze1_0\Util\Date;

  abstract class SchedulerJob
  {

    private static $enqueued_jobs = array();

    /**
     * @since 1.0
     */
    public function bootstrap(EnvironmentVariables $env)
    {
      if (!$this->interval) {
        throw new \Exception('Event Interval required but not given. Specify `protected $interval;` in '. get_called_class());
      }

      // Get next midnight timestamp.
      $now = new Date;
      $startTimestamp = $now->getDate()->modify('midnight tomorrow')->getTimestamp();

      $this->enqueueJob($env, $startTimestamp, $this->interval);
    }

    public function enqueueJob($env, $startTimestamp, $interval)
    {
      self::$enqueued_jobs[] = array(
        'start_time' => $startTimestamp,
        'interval' => $interval,
        'FQCN' => get_called_class(),
        'method' => 'execute',
        'app_name' => $env->getAppOptions('app_name')
      );
    }

    public static function getEnqueuedJobs()
    {
      return self::$enqueued_jobs;
    }

    public abstract function execute();
  }
}