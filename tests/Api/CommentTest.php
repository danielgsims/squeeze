<?php

use \Squeeze1_0\Api\Comment;

$wp_delete_comment_called = (object) array(
  'comment_id' => '',
  'true_delete' => '',
  'was_called' => false
);

function get_comment($comment_id) {
  return (object) array(
    'comment_ID' => $comment_id
  );
}

function wp_delete_comment($comment_id, $true_delete = false) {
  global $wp_delete_comment_called;
  $wp_delete_comment_called->comment_id = $comment_id;
  $wp_delete_comment_called->true_delete = $true_delete;
  $wp_delete_comment_called->was_called = true;
}

class CommentTest extends PHPUnit_Framework_TestCase
{
  private $emptyComment;
  private $realComment;

  private $dummyCommentId = 1234;

  public function __construct()
  {
    $this->emptyComment = new CommentImplementor;
    $this->realComment = new CommentImplementor($this->dummyCommentId);
  }

  public function testConstructorPDO()
  {
    $newcomment = new CommentImplementor;

    $this->assertInstanceOf('Squeeze1_0\\Db\\PDO', $newcomment->getPDO());
  }

  public function testConstructorTable()
  {
    global $wpdb;

    $newcomment = new CommentImplementor;

    $table_name = $wpdb->prefix .'comments';

    $this->assertEquals($newcomment->getTable(), $table_name);
  }

  public function testInterface()
  {
    $this->assertInstanceOf('\\Squeeze1_0\\Implementable\\iApi', $this->emptyComment);
  }

  public function testSetCoreField()
  {
    $this->emptyComment->set('comment_author', 10);

    $this->assertEquals($this->emptyComment->get('comment_author'), 10);
  }

  public function testSetMetaField()
  {
    $yo_momma = 'sooooooo fat';

    $this->emptyComment->set('yo_momma', $yo_momma);

    $this->assertEquals($this->emptyComment->get('yo_momma'), $yo_momma);
  }

  public function testDeleteRealComment()
  {
    global $wp_delete_comment_called;

    $this->realComment->delete();

    $this->assertEquals($wp_delete_comment_called->comment_id, $this->dummyCommentId);
    $this->assertEquals($wp_delete_comment_called->true_delete, true);
    $this->assertEquals($wp_delete_comment_called->was_called, true);

    // Reset back!
    $wp_delete_comment_called->comment_id = '';
    $wp_delete_comment_called->true_delete = '';
    $wp_delete_comment_called->was_called = false;
  }

  public function testDeleteCommentFailure()
  {
    $this->assertEquals($this->emptyComment->delete(), false);
  }

  public function testTrashRealComment()
  {
    global $wp_delete_comment_called;

    $this->realComment->trash();

    $this->assertEquals($wp_delete_comment_called->comment_id, $this->dummyCommentId);
    $this->assertEquals($wp_delete_comment_called->true_delete, false);
    $this->assertEquals($wp_delete_comment_called->was_called, true);

    // Reset back!
    $wp_delete_comment_called->comment_id = '';
    $wp_delete_comment_called->true_delete = '';
    $wp_delete_comment_called->was_called = false;
  }

  public function testTrashCommentFailure()
  {
    $this->assertEquals($this->emptyComment->trash(), false);
  }
}

/////////////////////

class CommentImplementor extends Comment
{
  public function getPDO()
  {
    return $this->PDO;
  }

  public function getTable()
  {
    return $this->table;
  }
}