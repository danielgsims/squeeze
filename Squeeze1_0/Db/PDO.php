<?php

namespace Squeeze1_0\Db
{

  use \PDO as defaultPDO;
  /**
   * PDO Wrapper. Creates a singleton instance and connects to the database.
   *
   * I like using PDO more than $wpdb, so here we are.
   * @since 1.0
   */
  class PDO extends defaultPDO
  {

    /**
     * @var object
     * @static
     * @since 1.0
     */
    private static $instance;

    /**
     * Creates a single instance of the class if it hasn't been instantiated yet.
     *
     * If we're creating a new instance, we'll inject the WordPress database credentials too
     * @return object \Squeeze1_0\Db\PDO
     * @since 1.0
     */
    public function __construct() {
      if (!is_a(self, self::$instance)) {
        parent::__construct('mysql:host='. \DB_HOST .';dbname='. \DB_NAME, \DB_USER, \DB_PASSWORD);
        $this->setAttribute(defaultPDO::ATTR_ERRMODE, defaultPDO::ERRMODE_EXCEPTION);
        $this->setAttribute(defaultPDO::ATTR_STATEMENT_CLASS, array('\Squeeze1_0\Db\PDOStatement', array($this)));

        self::$instance = $this;
      }

      return self::instance();
    }

    /**
     * Return a stored instance or create a new one
     * @return object \Squeeze1_0\Db\PDO
     * @since 1.0
     */
    public static function instance()
    {
      if (!is_object(self::$instance)) {
        return new self;
      }
      return self::$instance;
    }
  }
}