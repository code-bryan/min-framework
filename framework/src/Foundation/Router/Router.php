<?php

namespace Illuminare\Foundation\Router;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Symfony\Component\HttpFoundation\Request;

class Router
{
  public function __construct(
    protected array $controllers,
    protected Request $request,
  )
  {
    // 
  }

  public function handle(): RouteInfo
  {
    $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
      foreach ($this->controllers as $class => $rawPath) {
        $instance = new $class;
        $path = $this->getPath($rawPath, $instance);
        
        if (method_exists($instance, "index")) {
          $currentPath = strlen($path) === 0 ? '/' : $path;
          $routeCollector->addRoute("GET", $currentPath, [$class, 'index']);
        }

        if (method_exists($instance, "get")) {
          $routeCollector->addRoute("GET", $path . '/{id:\d+}', [$class, 'get']);
        }
      }
    });

    $routeInfo = $dispatcher->dispatch(
      $this->request->getMethod(),
      $this->request->getPathInfo(),
    );

    $route = new RouteInfo($routeInfo);

    return $route;
  }

  private function getPath(string $rawPath, object $instance)
  {
    $reflectionClass = new \ReflectionClass($instance);
    $className = "/{$reflectionClass->getShortName()}.php";
    $controllerPath = str_replace(BASE_CONTROLLERS_PATH, "", $rawPath);
    $path = str_replace($className, "", $controllerPath);

    return strtolower($path);
  }
}