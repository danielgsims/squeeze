<?php

namespace Squeeze1_0\Api
{
  use Squeeze1_0\EnvironmentVariables;

  abstract class SchedulerInterval
  {

    /**
     * @since 1.0
     */
    protected $interval;

    /**
     * @since 1.0
     */
    protected $display;

    /**
     * @since 1.0
     */
    public function bootstrap(EnvironmentVariables $env)
    {
      if (!$this->interval || !$this->display) {
        throw new \Exception('Required Interval Data not given');
      }

      add_filter('cron_schedules', array($this, 'add_cron_interval'));
    }

    /**
     * @since 1.0
     */
    public function add_cron_interval($schedules)
    {
      $schedules[$this->getSlug()] = array(
        'interval' => $this->interval,
        'display' => $this->display
      );

      return $schedules;
    }

    /**
     * @since 1.0
     */
    private function getSlug()
    {
      $className = get_called_class();
      $className = explode('\\', $className);
      return strtolower(end($className));
    }
  }
}