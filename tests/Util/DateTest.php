<?php

use \Squeeze1_0\Util\Date;

class DateTest extends PHPUnit_Framework_TestCase
{
  private $dateObj;
  private $sqDateObj;

  public function __construct()
  {
    $this->dateObj = new DateTime;
    $this->sqDateObj = new Date($this->dateObj);
  }

  public function testDateStorage()
  {
    $this->assertEquals($this->dateObj, $this->sqDateObj->getDate());
  }

  public function testWeekDateRange()
  {
    $range = $this->sqDateObj->getWeekDateRange();
    $diff = $range['start_date']->diff($range['end_date']);
    $this->assertEquals($diff->d, 7);
  }

  public function testSetDateFormat()
  {
    $this->sqDateObj->setDateFormat('Y');
    $this->assertEquals((string) $this->sqDateObj, date('Y'));
  }
}