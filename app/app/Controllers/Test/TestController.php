<?php

namespace App\Controllers\Test;

class TestController
{
  public function index()
  {
    $content = '<h1>Hello From Test</h1>';
    echo $content;
  }

  public function get(int $id)
  {
    $content = "<h1>Test #{$id}</h1>";
    echo $content;
  }
}