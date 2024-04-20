<?php

namespace Illuminare\Foundation;

use Symfony\Component\HttpFoundation\Request;
use Composer\ClassMapGenerator\ClassMapGenerator;

class Kernel
{
  protected Request $request;

  public function __construct()
  {
    $this->request = Request::createFromGlobals();
  }

  public function handle()
  {
    foreach ($this->getControllerInstances() as $class => $path) {
      $instance = new $class;
      echo $instance->index();
    }
  }

  protected function getControllerInstances()
  {
    return ClassMapGenerator::createMap(BASE_CONTROLLERS_PATH);
  }
}