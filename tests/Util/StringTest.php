<?php

use \Squeeze1_0\Util\String;

class StringTest extends PHPUnit_Framework_TestCase
{
  public function testUnderscoreToCamelCase()
  {
    $underscore = 'my_test_string';
    $camelcase = 'myTestString';
    $herocase = 'MyTestString';

    $firstCharUpperCase = String::underscoreToCamelCase($underscore, true);
    $firstCharLowerCase = String::underscoreToCamelCase($underscore, false);

    $this->assertEquals($firstCharLowerCase, $camelcase);
    $this->assertEquals($firstCharUpperCase, $herocase);
  }

  public function testFirstCharUpperCase()
  {
    $lowercase = 'helloworld';
    $uppercase = 'Helloworld';
    $this->assertEquals(String::firstCharUpperCase($lowercase), $uppercase);
  }

  public function testFirstCharLowerCase()
  {
    $lowercase = 'helloworld';
    $uppercase = 'Helloworld';
    $this->assertEquals(String::firstCharLowerCase($uppercase), $lowercase);
  }
}