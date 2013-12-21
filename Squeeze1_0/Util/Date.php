<?php

namespace Squeeze1_0\Util
{
  use \DateTime;

  /**
   * Date
   * Date Helper Functions
   * @since 1.0
   */
  class Date
  {

    /**
     * @access private
     * @var object DateTime
     * @since 1.0
     */
    private $date;

    /**
     * @access private
     * @var string
     * @since 1.0
     */
    private $date_format = 'Y-m-d H:i:s';

    /**
     * __construct
     * Set the date that we'll be running operations on later.
     * If none is supplied a new instance of DateTime will be used.
     * @param DateTime|null $date
     * @return null
     * @access public
     * @since 1.0
     */
    public function __construct(DateTime $date = null)
    {
      if (is_null($date)) {
        $this->date = new DateTime;
      }
      else {
        $this->date = $date;
      }
    }

    /**
     * getDate
     * Return the stored Date object.
     * @return DateTime
     * @access public
     * @since 1.0
     */
    public function getDate()
    {
      return $this->date;
    }

    /**
     * getWeekDateRange
     * Returns an array of DateTime objects
     * `start_date` is the beginning of the week
     * `end_date` is the end of the week.
     * @return array
     * @access public
     * @since 1.0
     */
    public function getWeekDateRange()
    {
      $startDate = $this->date->modify('midnight');
      if ($startDate->format('l') !== 'Sunday') {
        $startDate = $this->date->modify('last Sunday');
      }

      $endDate = clone $startDate;
      $endDate->modify('+7 days');
      return array(
        'start_date' => $startDate,
        'end_date' => $endDate
      );
    }

    /**
     * setDateFormat
     * Change the default date format
     * @param string $format
     * @return \Squeeze1_0\Util\Date
     * @since 1.0
     */
    public function setDateFormat($format)
    {
      $this->date_format = $format;
      return $this;
    }

    /**
     * __toString
     * Magic method to return the current instance as a string.
     * If Date::$date_format has been changed, this function will use that as the format.
     * If not, we'll fall back to a MySQL compatible date format.
     * @return string
     * @since 1.0
     */
    public function __toString()
    {
      return $this->date->format($this->date_format);
    }
  }
}