<?php
define('Zovercy',__DIR__.'/');
define('SITE_ROOT', dirname(dirname(__DIR__)). '/');
date_default_timezone_set('PRC');
include Zovercy.'Engine/Load.php';

function __autoload($className) {
    $map=load::map();
    $apiDir=Zovercy.'Api/'.$className.'.php';
    if(file_exists($apiDir)){
        include $apiDir;
    }else{
        if(array_key_exists($className,$map)){
            include Zovercy.$map[$className].$className.'.php';
        }else{
            die("Unable to load class $className.");
        }
    }
}

include Zovercy.'Helper/Basic.php';
include Zovercy . 'Engine/Z.php';
include SITE_ROOT . 'config/config.php';
include Zovercy . 'Engine/Base.php';
include Zovercy . 'Engine/Factory.php';

class Shell {
    function __construct() {
        $this->init();
        $databaseConfig=include SITE_ROOT.'config/database.php';
        DB::init($databaseConfig);
    }

    private function init() {
        //date_default_timezone_set('PRC'); //设置中国时区
        Base::debug(Z::$config['DEBUG']); //开发模式
    }

    public function run($argv) {
		if(!isset($argv[1])){
			echo ('no argv');
			exit();
		}
		$c=explode('.',$argv[1]);
		if(count($c)<2){
			echo('no no no');
			exit();
		}
		$controller=$c[0];
		$action=$c[1];
		include SITE_ROOT.'appcli/'.$controller.'.php';

        $prams=array();
        if(count($argv)>2) {
            unset($argv[0]);
            unset($argv[1]);
            $prams=$argv;
        }

		$this->reflect($controller,$action,$prams);
		exit();
    }

    function __destruct() {
       //DB::disconnect();
    }

	private function reflect($classname,$methodname,$prams=array()){
	        //$classname=Z::$controller;
            //$methodname=Z::$action;
            if (!class_exists($classname)) {
                echo("No Class : " . $classname);
				exit();
            }
            $class = new ReflectionClass($classname);
            if (!$class->hasMethod($methodname)) {
                echo("No Method : " . $classname . ' -> ' . $methodname);
				exit();
            }
            $method=new ReflectionMethod($classname,$methodname);
            if($method->isPrivate()){
                echo("Private Method  : " . $classname . ' -> ' . $methodname);
				exit();
            }
            $instance = $class->newInstance();
            if(empty($prams)){
                $method->invoke($instance);
            }else{
                $method->invokeArgs($instance,$prams);
            }
	}
}
