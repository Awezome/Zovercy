<?php
/**
 * User: zyp
 * Date: 2019-04-11
 * Time: 11:04
 */
require_once __DIR__ . '/vendor/autoload.php';
use Workerman\Worker;

Class App{
    private $worker=null;
    private $router=null;

    function __construct()
    {
        $this->worker=new Worker("http://0.0.0.0:2345");
        $this->worker->count=1;
        $this->worker->onWorkerStart=function (){
            $this->onWorkerStart();
        };
        $this->worker->onMessage = function($connection, $data)
        {
            $this->onMessage($connection, $data);
        };
    }

    private function onWorkerStart(){
        echo 'worker is start...'.PHP_EOL;
        $this->router = new \Zovercy\Http\Router(__DIR__.'/app/Routes/api.php');
    }

    private function onMessage($connection, $data){
        $request=new \Zovercy\Http\Request();
        $response=new \Zovercy\Http\Response();
        $this->router->dispatch($request,$response);
        $connection->send($response->toJson());
    }

    function run(){
        Worker::runAll();
    }

}

(new App)->run();
