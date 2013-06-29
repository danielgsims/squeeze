<?php

namespace Squeeze\Core\Util;
/**
 * Date
 * Date Helper Functions
 */
class Date
{

  /**
   * @access private
   * @var object DateTime
   */
  private $date;

  /**
   * @access private
   * @var string
   */
  private $date_format = 'Y-m-d H:i:s';

  /**
   * __construct
   * Set the date that we'll be running operations on later.
   * If none is supplied a new instance of DateTime will be used.
   * @param DateTime|null $date
   * @return null
   * @access public
   */
  public function __construct(DateTime $date = null)
  {
    if (is_null($date)) {
      $this->date = new \DateTime;
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
   * @return \Squeeze\Core\Util\Date
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
   */
  public function __toString()
  {
    return $this->date->format($this->date_format);
  }
}