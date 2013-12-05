<?php

use \Squeeze1_0\Bootstrapper;

class BootstrapperTest extends PHPUnit_Framework_TestCase
{
  public function testEmpty()
  {
    $bootstrapper = new Bootstrapper;

    $this->assertClassHasAttribute('appEnv', '\\Squeeze1_0\\Bootstrapper');

    return $bootstrapper;
  }
}