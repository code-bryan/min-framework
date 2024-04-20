<?php

namespace App\Controllers\Post;

class PostController
{
  public function index()
  {
    $content = '<h1>hello from post</h1>';
    echo $content;
  }

  public function get(int $id)
  {
    $content = "<h1>Post number $id</h1>";
    echo $content;
  }
}