<?php

namespace App\Controllers;

class PostController
{
  public function index()
  {
    $content = '<h1>Hello From Post</h1>';
    echo $content;
  }

  public function get(int $id)
  {
    $content = "<h1>Post {$id}</h1>";
    echo $content;
  }
}