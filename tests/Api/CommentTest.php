<?php

use \Squeeze1_0\Api\Comment;

class CommentTest extends PHPUnit_Framework_TestCase
{
  private $comment;

  public function __construct()
  {
    $this->comment = new Comment;
  }

  public function testInterface()
  {
    $this->assertInstanceOf('\\Squeeze1_0\\Implementable\\iApi', $this->comment);
  }

  public function testSetCoreField()
  {
    $this->comment->set('comment_author', 10);

    $this->assertEquals($this->comment->get('comment_author'), 10);
  }

  public function testSetMetaField()
  {
    $yo_momma = 'sooooooo fat';

    $this->comment->set('yo_momma', $yo_momma);

    $this->assertEquals($this->comment->get('yo_momma'), $yo_momma);
  }
}