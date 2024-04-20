<?php

namespace Illuminare\Foundation\Router;

readonly class RouteInfo
{
  public string $controller;
  public string $method;
  public int $status;
  public array $parameters;

  public function __construct(private array $routeInfo)
  {
    [$status, $handler, $vars] = $routeInfo;
    [$controller, $method] = $handler;

    $this->controller = $controller;
    $this->method = $method;
    $this->status = $status;
    $this->parameters = $vars;
  }
}