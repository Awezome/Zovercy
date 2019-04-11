<?php

namespace Zovercy;

use Workerman\Worker;

class Zovercy{
    private $worker=null;
    private $router=null;
    private $basePath='';
    private $config=[];

    function __construct($basePath)
    {
        $this->basePath=$basePath;
        $this->loadConfig();
    }

    private function onWorkerStart(){
        echo 'worker is start...'.PHP_EOL;
        $this->loadRouter();
    }

    public function loadConfig(){
        foreach (glob($this->basePath.'/config/*.php') as $v){
            $value=include $v;
            $key=strstr(basename($v),'.',true);
            $this->config[$key]=$value;
        }
    }

    public function loadRouter(){
        $this->router = new Http\Router($this->basePath.'/app/Routes/api.php');
    }

    public function getConfig($key){
        $key=explode('.',$key);
        return $this->config[$key[0]][$key[1]];
    }

    public function run(){
        $config=$this->getConfig('app.workerman');
        $this->worker=new Worker($config['listen']);
        $this->worker->count=$config['worker_nums'];
        $this->worker->onWorkerStart=function (){
            $this->onWorkerStart();
        };
        $this->worker->onMessage = function($connection, $data)
        {
            $code=200;
            $request=new Http\Request();
            $response=new Http\Response();
            try{
                $this->router->dispatch($request,$response);
                $data=$response->toJson();
            }catch (\Exception $e){
                $data=$e->getMessage();
                $code=500;
            }finally{
                $response->setHeader('json',$code);
                $connection->send($data);
            }
        };
        Worker::runAll();
    }

}
