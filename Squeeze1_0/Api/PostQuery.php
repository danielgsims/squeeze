<?php

namespace Squeeze1_0\Api
{
  use \Squeeze1_0\Api\Post;
  use \WP_Query;

  class PostQuery
  {
    private $posts;
    private $query;

    public function __construct(WP_Query $query)
    {
      $this->query = $query;
      if (is_array($query->posts)) {
        foreach ($query->posts as $post) {
          $this->posts[$post->ID] = new Post($post);
        }
      }
    }
  }
}