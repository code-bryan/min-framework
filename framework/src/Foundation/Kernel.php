<?php

namespace Illuminare\Foundation;

use Illuminare\Foundation\Router\Router;
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
    $router = new Router(
      $this->getControllerInstances(), 
      $this->request,
    );

    $handler = $router->handle();
    $routeHandler = [new $handler->controller, $handler->method];
    $response = call_user_func_array($routeHandler, $handler->parameters);

    return $response;
  }

  protected function getControllerInstances()
  {
    return ClassMapGenerator::createMap(BASE_CONTROLLERS_PATH);
  }
}