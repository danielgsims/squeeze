<?php

use \Squeeze1_0\Util\Input;

class InputTest extends PHPUnit_Framework_TestCase
{
  public function testGet()
  {
    $blah = 'blahBlah';
    $_GET['blah'] = $blah;

    $this->assertEquals(Input::get('blah'), $blah);

    $blah = array('blah' => 'blahBlah');
    $_GET = $blah;

    $this->assertEquals(Input::get(), $blah);
    $_GET = array();
  }

  public function testPost()
  {
    $blah = 'blahBlah';
    $_POST['blah'] = $blah;

    $this->assertEquals(Input::post('blah'), $blah);

    $blah = array('blah' => 'blahBlah');
    $_POST = $blah;

    $this->assertEquals(Input::post(), $blah);
    $_POST = array();
  }

  public function testCookie()
  {
    $blah = 'blahBlah';
    $_COOKIE['blah'] = $blah;

    $this->assertEquals(Input::cookie('blah'), $blah);

    $blah = array('blah' => 'blahBlah');
    $_COOKIE = $blah;

    $this->assertEquals(Input::cookie(), $blah);
    $_COOKIE = array();
  }

  public function testServer()
  {
    $blah = 'blahBlah';
    $_SERVER['blah'] = $blah;

    $this->assertEquals(Input::server('blah'), $blah);

    $this->assertEquals(Input::server(), $_SERVER);
  }

  // public function testSanitize()
  // {
  //   $badString = "hello world'--";

  //   $this->assertEquals(Input::sanitize($badString), mysql_real_escape_string($badString));
  // }
}