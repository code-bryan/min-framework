<?php

namespace App\Controllers;

class HomeController
{
  public function index()
  {
    $content = '<h1>Hello Word</h1>';
    // Handle this using a respond class instead of this
    echo $content;
  }

  public function get(int $id)
  {
    $content = "<h1>Hello Word {$id}</h1>";
    echo $content;
  }
}