<?php

namespace Illuminare\Foundation\Router;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Symfony\Component\HttpFoundation\Request;

class Router
{
  private string $home = "/home";
  private readonly array $paths;

  public function __construct(
    protected array $controllers,
    protected Request $request,
  )
  {
    $this->paths = $this->getPaths() ?: [];
  }

  public function handle()
  {
    $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
      foreach ($this->paths as $route) {
        [$path, $class, $instance] = $route;

        if (method_exists($instance, "index")) {
          $routeCollector->addRoute("GET", $path, [$class, 'index']);
        }
        if (method_exists($instance, "get")) {
          // TODO: avoid using declarative params or read arguments of a method
          $routeCollector->addRoute("GET", $path . '/{id:\d+}', [$class, 'get']);
        }

        // TODO: create other methods to be read
      }
    });

    $routeInfo = $dispatcher->dispatch(
      $this->request->getMethod(),
      $this->request->getPathInfo(),
    );

    // TODO redirect to a Error class 
    
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

  private function getPaths(): array
  {
    $paths = array_map(function($class) {
      $instance = new $class;

      $currentPath = $this->getPathName($instance);

      $isHome = $currentPath == $this->home;

      $path = $isHome ? "/" : $currentPath;

      return [$path, $class, $instance];
    }, array_keys($this->controllers));

    return $paths;
  }

  private function getPathName(object $instance)
  {
    $reflectionClass = new \ReflectionClass($instance);
    $className = "/{$reflectionClass->getShortName()}.php";
    
    $name = strtolower(str_replace("Controller.php", "", $className));
    return $name;
  }
}