<?php
namespace Zovercy\Http;
use FastRoute;

class Router
{
    private $router=null;

    function __construct($routerMaps)
    {
        $this->router = FastRoute\simpleDispatcher(
            function(FastRoute\RouteCollector $router) use ($routerMaps){
                include $routerMaps;
            }
        );
    }

    public function dispatch(Request $request, Response $response){
        $routeInfo = $this->router->dispatch($request->method(), $request->uri());
        $content=null;
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed  方法不允许
                break;
            case FastRoute\Dispatcher::FOUND:
                $handle = $routeInfo[1];
                $params = $routeInfo[2]??null;
                $content=$this->callController($handle,$params);
                break;
        }

        $response->setContent($content);
    }

    private function callController($handle,$params){
        $handle=explode('@',$handle);
        $class=$handle[0];
        $method=$handle[1];

        $mainClass = '\\App\\Controllers\\' . $class;
        return (new $mainClass())->$method($params);
    }
}
