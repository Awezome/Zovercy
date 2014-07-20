<?php
define('CLOUD_ROOT',__DIR__.'/');
define('SITE_ROOT', dirname(dirname(__DIR__)). '/');

include CLOUD_ROOT.'Engine/Load.php';

function __autoload($className) {
    $map=load::map();
    $apiDir=CLOUD_ROOT.'api/'.$className.'.php';
    if(file_exists($apiDir)){
        include $apiDir;
    }else{
        if(array_key_exists($className,$map)){
            include CLOUD_ROOT.$map[$className].$className.'.php';
        }else{
            die("Unable to load class $className.");
        }
    }
}

include CLOUD_ROOT.'Helper/Basic.php';
include CLOUD_ROOT . 'Engine/Z.php';
include SITE_ROOT . 'config/config.php';
include CLOUD_ROOT . 'Engine/Base.php';
include CLOUD_ROOT . 'Engine/Factory.php';

class Shell {

    private static $onauth = true;
    private static $onredis = false;

    function __construct() {
        $this->init();

     //   $databaseConfig=include SITE_ROOT.'config/database.php';
     //   DB::init($databaseConfig);
     //   DB::connect('default');
        //DB::log(true);
    }

    private function init() {
        date_default_timezone_set('PRC'); //设置中国时区
        Base::debug(Z::$config['DEBUG']); //开发模式
    }

    public function run($argv) {
		if(!isset($argv[1])){
			g('no argv');
			exit();
		}
		$c=explode('.',$argv[1]);
		if(count($c)<2){
			g('no no no');
			exit();
		}
		$controller=$c[0];
		$action=$c[1];
		include SITE_ROOT.'appcli/'.$controller.'.php';
		$this->reflect($controller,$action);
		exit();
    }

    function __destruct() {
        //todo : DB::close();
    }

    function redis($on) {
        self::$onredis = $on;
    }

    private function runRedis() {
        Z::$redis = new Redis();
        if (Z::$redis->connect(Z::$config['REDIS']['HOST'], Z::$config['REDIS']['PORT'])) {
            Z::$redison = true;
        } else {
            Z::$redison= false;
        }
    }
	
	private function reflect($classname,$methodname){
	        //$classname=Z::$controller;
            //$methodname=Z::$action;
            if (!class_exists($classname)) {
                g("No Class : " . $classname);
				exit();
            }
            $class = new ReflectionClass($classname);
            if (!$class->hasMethod($methodname)) {
                g("No Method : " . $classname . ' -> ' . $methodname);
				exit();
            }
            $method=new ReflectionMethod($classname,$methodname);
            if($method->isPrivate()){
                g("Private Method  : " . $classname . ' -> ' . $methodname);
				exit();
            }
            $instance = $class->newInstance();
            $method->invoke($instance);
	}

}
