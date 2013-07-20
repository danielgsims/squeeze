# SQUEEZE Plugin Framework

Rapid WordPress plugin development using modern techniques and principles. I was tired of writing WordPress plugins that sucked. So I started writing Squeeze. Squeeze provides an MVC structure for plugin development, utilizing modern principles such as namespacing and autoloading, parameterized queries, object oriented data management and API access and more.

Squeeze is meant for software engineers. But more than that, Squeeze is meant for anyone who wants to rapidly develop maintainable, standards-based plugins for the most popular platform on earth.

If you've ever taken a freelance job working on a WordPress project, you may find Squeeze useful.

If you find this useful please let me know. If you've got a question, please let me know. If you want to contribute, I'd be stoked.

### Developing An App
Squeeze functions as an external dependency that lives in your `wp-content/plugins` directory. For an example of how Squeeze is implemented as a development framework, check out the **[squeezeExample WordPress Plugin](https://github.com/jdpedrie/squeezeExample)**.

### Features
* Create custom settings/options pages
* Custom Post Type Support
* Custom Meta Boxes on Custom and Core post types.
* Manage Users (Insert, Update, Delete, Set Roles)
* Manage Posts (Insert, Update, Delete, Trash)
* Manage Comments (Insert, Update, Delete, Trash)
* Manage WordPress Options in an object-oriented fashion.
* Fetch and Save User Metadata
* Add columns to the User List
* Represents data in an object-oriented fashion
* PDO wrapper for parameterized queries
* MVC structure

### Examples
* Create an Admin Page

    ```
    cd SqueezeExample/App/Controller
    touch MyAdminPage.php
    ```
    ```
    <?php
    
    namespace SqueezeExample\App\Controller;
    
    class MyAdminPage extends \Squeeze1_0\Core\Mvc\AdminPageController
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
    cd SqueezeExample/App/Controller
    touch MyDashboardWidget.php
    ```
    ```
    <?php

    namespace Squeeze\App\Controller;
    
    class MyDashboardWidget extends \Squeeze1_0\Core\Mvc\DashboardWidget
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
    $myPost = new \Squeeze1_0\Api\Post($post_ID);
    $myPost->set('post_title', 'Hello World');
    $meta_value = $myPost->get('number_of_views');
    $myPost->set('number_of_views', $meta_value++);
    $myPost->save();
    ```
* Create a custom MySQL Query

    ````
    <?php
    $PDO = \Squeeze1_0\Db\PDO::instance();
    $query = $PDO->query('SELECT * FROM wp_posts LIMIT 1');

    $post = $query->fetch();
    echo $post->post_title();
    ````

### A word on style
I've consciously chosen to adhere* to PSR-2 over the WordPress code style guide. For one thing, PSR is a more widely accepted and interoperable standard. I'm making extensive use of the PSR-style autoloader, and Squeeze is built to easily integrate any PSR-compatible Composer module. PSR is a professional standard that is used by a larger percentage of the PHP community. And finally, while none of this should be taken to imply that I believe there is anything wrong with the WordPress style guide, I simply prefer and am used to using the PSR standard.

At the end of the day, the most important thing isn't which style you choose to follow, or even that you're completely implementing one or another, the important thing is that you choose a coding style and implement it uniformly throughout a project.

(* The notable exception is my use of two spaces rather than the four specified in PSR. It's a carryover from my language du jour, Javascript, and it's purely a personal preference.)

### Authors
Squeeze is written by me, [John Dennis Pedrie](http://johnpedrie.com). Thanks to [David Supplee](http://github.com/dwsupplee) for code reviews and useful suggestions.

### License
Squeeze is licensed under the MIT License. A copy of the MIT License may be found in the repository under `LICENSE.md`.