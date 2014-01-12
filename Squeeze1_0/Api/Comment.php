<?php

namespace Squeeze1_0\Api
{
  use Squeeze1_0\Db\PDO;
  use Squeeze1_0\Db\Config as dbConfig;
  use Squeeze1_0\Implementable\iApi;

  /**
   * An API for managing comments
   * @since 1.0
   */
  class Comment implements iApi
  {

    /**
     * Holds our PDO instance
     * @var object
     * @since 1.0
     */
    protected $PDO;

    /**
     * The Comments Table name
     * @var string
     * @since 1.0
     */
    protected $table;

    /**
     * An array that's populated with any required fields that aren't filled out.
     * Used by Comment::checkRequiredFields()
     * @var array
     * @since 1.0
     */
    protected $missing_fields = array();

    /**
     * A list of fields in the comments table.
     * If a variable is set that doesn't exist in this array,
     * it will be saved as metadata.
     * @var array
     * @since 1.0
     */
    protected $core_fields = array(
      'comment_ID' => false,
      'comment_post_ID' => false,
      'comment_author' => false,
      'comment_author_email' => false,
      'comment_author_url' => false,
      'comment_author_IP' => false,
      'comment_date' => false,
      'comment_date_gmt' => false,
      'comment_content' => false,
      'comment_karma' => false,
      'comment_approved' => false,
      'comment_agent' => false,
      'comment_type' => false,
      'comment_parent' => false,
      'user_id' => false
    );

    /**
     * A list of fields required to insert a comment
     * @var array
     * @since 1.0
     */
    protected $required_fields = array(
      'comment_post_ID',
      'comment_author',
      'comment_author_email',
      'comment_date',
      'comment_content'
    );

    /**
     * Any variables set that don't exist in Comment::$core_fields are stored here
     * and saved as metadata.
     * @var array
     * @since 1.0
     */
    protected $meta = array();

    /**
     * If we're trying to load an existing comment, the comment ID will be stored here
     * @var int
     * @since 1.0
     */
    protected $comment_ID;

    /**
     * Attempt to load a comment if $commentId is set
     * @param int|null $commentId
     * @return object \Squeeze1_0\Api\Comment
     * @since 1.0
     */
    public function __construct($commentId = NULL)
    {
      $this->PDO = PDO::instance();
      $this->table = $commentsTable = dbConfig::prefix() .'comments';

      if (!is_null($commentId)) {
        $this->comment_ID = $commentId;

        $comment = get_comment($commentId);
        if (is_object($comment)) {
          $this->hydrate($comment);

          $PDO = PDO::instance();
          $meta = $PDO->prepare("SELECT meta_key, meta_value FROM wp_commentmeta WHERE comment_id = :commentId");
          $meta->execute(array('commentId' => $commentId));
          $fields = $meta->fetchAll();
          if (count($fields) > 0) {
            foreach ($fields as $field) {
              $this->meta[$field['meta_key']] = $field['meta_value'];
            }
          }
        }
      }
    }

    /**
     * Set or change the value of a comment variable
     * If the key exists in Comment::$core_fields, use that,
     * otherwise store as metadata.
     * @param string $key
     * @param string $val
     * @return object \Squeeze1_0\Api\Comment;
     * @since 1.0
     */
    public function set($key, $val)
    {
      if (array_key_exists($key, $this->core_fields)) {
        $this->core_fields[$key] = $val;
      }
      else {
        $this->meta[$key] = $val;
      }

      return $this;
    }

    /**
     * Get a stored value
     * First try to fetch from Comment::$core_fields
     * then fall back to Comment::$meta.
     * Return null if nothing found.
     * @param string $key
     * @return mixed;
     * @since 1.0
     */
    public function get($key)
    {
      if (array_key_exists($key, $this->core_fields)) {
        return $this->core_fields[$key];
      }

      return (isset($this->meta[$key])) ? $this->meta[$key] : null;
    }

    /**
     * Insert or update the comment
     * @return int
     * @since 1.0
     */
    public function save()
    {
      if($this->comment_ID) {
        return $this->updateComment();
      }
      else {
        return $this->insertComment();
      }
    }

    /**
     * Will delete a comment.
     * NOTE: This attempts to complete a true delete.
     * Use Comment::trash() to trash a comment
     * @return bool
     * @since 1.0
     */
    public function delete()
    {
      if($this->comment_ID) {
        return wp_delete_comment($this->comment_ID, true);
      }

      return false;
    }

    /**
     * Will trash a comment.
     * NOTE: This function will move a comment to the trash
     * Use Comment::delete() to delete a comment
     * @return bool
     * @since 1.0
     */
    public function trash()
    {
      if($this->comment_ID) {
        return wp_delete_comment($this->comment_ID, false);
      }

      return false;
    }

    /**
     * Populate the object with the comment values retrieved from the database
     * @param stdClass $comment
     * @return void
     * @since 1.0
     */
    protected function hydrate($comment)
    {
      $this->meta = array();
      foreach ($comment as $key=>$val) {
        if (array_key_exists($key, $this->core_fields)) {
          $this->core_fields[$key] = $val;
        }
        else {
          $this->meta[$key] = $val;
        }
      }
    }

    /**
     * Attempt to perform an INSERT
     * @return void|int
     * @since 1.0
     */
    protected function insertComment()
    {
      if (!$this->core_fields['comment_date']) {
        $date = new \Squeeze1_0\Util\Date;
        $this->core_fields['comment_date'] = (string)$date;
      }

      $this->checkRequiredFields();

      $vars = $this->core_fields;
      $keys = array_keys($vars);

      $fieldsClause = implode( ', ', $keys );
      $valuesClause = implode( ', ', array_map( create_function( '$value', 'return ":" . $value;' ), $keys ) );
      $sql = sprintf( 'INSERT INTO %s ( %s ) VALUES ( %s )', $this->table, $fieldsClause, $valuesClause );

      $stmt = $this->PDO->prepare($sql);
      $stmt->execute( $vars );
      return $stmt->insertId();
    }

    /**
     * Attempt to update a comment
     * @return int \Squeeze1_0\Api\Comment::comment_ID
     * @since 1.0
     */
    protected function updateComment()
    {
      $vars = $this->core_fields;
      $keys = array_keys($this->core_fields);

      $update = array();
      foreach ($keys as $key) {
        $update[] = $key .' = :'. $key;
      }
      $update = implode(', ', $update);

      $vars['comment_ID'] = $this->comment_ID;

      $sql = $sql = 'UPDATE '. $this->table .' SET '. $update .' WHERE comment_ID = :comment_ID';
      // echo $sql;exit;
      $stmt = $this->PDO->prepare($sql);
      $stmt->execute( $vars );

      return $this->comment_ID;
    }

    /**
     * Check the values stored in Comment::$core_fields
     * against those in Comment::$required_fields
     * Throw an exception if fields are missing
     * @todo Find a better way to show errors than exceptions.
     * @since 1.0
     */
    private function checkRequiredFields()
    {
      $requiredFields = $this->required_fields;
      $this->missing_fields = array();

      array_walk($requiredFields, function($item, $key) {
        if (!$this->core_fields[$item]) {
          $this->missing_fields[] = $item;
        }
      });

      if(!empty($this->missing_fields)) {
        throw new \Squeeze1_0\Exception('Required fields are missing: '. implode(', ', $this->missing_fields));
      }
    }
  }
}