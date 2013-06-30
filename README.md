SQUEEZE Plugin Framework
========================

Rapid WordPress plugin development using modern techniques and principles. I was tired of writing WordPress plugins that sucked. So I started writing Squeeze. Squeeze provides an MVC structure for plugin development, utilizing modern principles such as namespacing and autoloading, parameterized queries, object oriented data management and API access and more.

Squeeze is meant for software engineers. But more than that, Squeeze is meant for anyone who wants to rapidly develop maintainable, standards-based plugins for the most popular platform on earth.

If you've ever taken a freelance job working on a WordPress project, you may find Squeeze useful.

If you find this useful please let me know. If you've got a question, please let me know. If you want to contribute, I'd be stoked.

Features
========
* Create custom settings/options pages
* Custom Post Type Support
* Manage Users (Insert, Update, Delete, Set Roles)
* Manage Posts (Insert, Update, Delete, Trash)
* Manage Comments (Insert, Update, Delete, Trash)
* Manage WordPress Options in an object-oriented fashion.
* Fetch and Save User Metadata
* Add columns to the User List
* Represents data in an object-oriented fashion
* PDO wrapper for parameterized queries
* MVC structure

Examples
========
* Create an Admin Page

    ```
    cd Squeeze/App/Controller
    touch MyAdminPage.php
    ```
    ```
    <?php
    
    namespace Squeeze\App\Controller;
    
    class MyAdminPage extends \Squeeze\Core\Mvc\AdminPageController
    {
      protected $page_title = 'My Admin Page';
      protected $capability = 'manage_options';
    
      public function __construct()
      {
        parent::__construct();
      }
    
      public function index()
      {
        echo "Hello World!";
      }
    
    }
    ```
* Create an Admin Dashboard Widget

    ```
    cd Squeeze/App/Controller
    touch MyDashboardWidget.php
    ```
    ```
    <?php

    namespace Squeeze\App\Controller;
    
    class MyDashboardWidget extends \Squeeze\Core\Mvc\DashboardWidget
    {
      protected $title = 'Squeezed Widget';
    
      public function index()
      {
        echo "Hello World!";
      }
    }
    ```
* Change a Post Title and increment the value of a meta field

    ```
    <?php
    
    $post_ID = 1;
    $myPost = new \Squeeze\Core\Api\Post($post_ID);
    $myPost->set('post_title', 'Hello World');
    $meta_value = $myPost->get('number_of_views');
    $myPost->set('number_of_views', $meta_value++);
    $myPost->save();
    ```
* Create a custom MySQL Query

    ````
    <?php
    $PDO = \Squeeze\Core\Db\PDO::instance();
    $query = $PDO->query('SELECT * FROM wp_posts LIMIT 1');

    $post = $query->fetch();
    echo $post->post_title();
    ````

TODO
====
* Add Test Coverage.
* Add support for Post Type meta boxes.
* Add ability to generate tables from any dataset.
* Add Pake support for build process (Prevent namespace collisions with multiple Squeeze instances).