<?php
namespace Zovercy\Http;
use FastRoute;

class Router
{
    private $router=null;

    function __construct()
    {
        $this->router = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/users', 'get_all_users_handler');
        });
    }

    public function dispatch(Request $request, Response $response){
        $routeInfo = $this->router->dispatch($request->method(), $request->uri());
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed  方法不允许
                break;
            case FastRoute\Dispatcher::FOUND: // 找到对应的方法
                $handler = $routeInfo[1]; // 获得处理函数
                $vars = $routeInfo[2]; // 获取请求参数
                // ... call $handler with $vars // 调用处理函数
                break;
        }

        $response->setContent('response set data');
    }
}
