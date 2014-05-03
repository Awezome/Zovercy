<?php
define('CLOUD_ROOT',__DIR__.'/');
define('SITE_ROOT', dirname(dirname(__DIR__)). '/');

include CLOUD_ROOT.'Engine/Load.php';

function __autoload($className) {
    $map=load::map();
    if(array_key_exists($className,$map)){
        include CLOUD_ROOT.$map[$className].$className.'.php';
    }else{
        die("Unable to load class $className.");
    }
}

include CLOUD_ROOT.'Helper/Basic.php';
include CLOUD_ROOT . 'Engine/Z.php';
include SITE_ROOT . 'config/config.php';
include CLOUD_ROOT . 'Engine/Base.php';
include CLOUD_ROOT . 'Engine/Controller.php';
include CLOUD_ROOT . 'Engine/Router.php';
include CLOUD_ROOT . 'Engine/Reflect.php';
include CLOUD_ROOT . 'Engine/Auth.php';
include CLOUD_ROOT . 'Engine/Factory.php';

class App {

    private static $onauth = true;
    private static $onredis = false;

    function __construct() {
        $this->init();

        Router::run();

        $databaseConfig=include SITE_ROOT.'config/database.php';
        DB::init($databaseConfig);
        DB::connect('default');
        //DB::log(true);

        $this->user();
        session_start();
        header('Content-Type:text/html;charset=' . Z::$config['CHARSET']);
    }

    private function init() {
        date_default_timezone_set('PRC'); //设置中国时区
        Base::debug(Z::$config['DEBUG']); //开发模式
    }

    public function run() {
        $controller = SITE_ROOT .'app/'. Z::$app .'/controller/'. Z::$controller . '.php';
        if (!is_file($controller)) {
            Func::errorMessage("No Controller : " . Z::$app .'/'. Z::$controller);
        }

        $this->user();

        if (self::$onauth) {
            Auth::run();
        }

        if (self::$onredis) {
            $this->runRedis();
        }

        include $controller;

        Reflect::run();
    }

    function __destruct() {
        //todo : DB::close();
    }

    private function user() {
        Z::$username = Cookie::get('username');
        Z::$userid = Check::number(Cookie::get('userid'));
        Z::$roleid = Check::number(Cookie::get('roleid'));
        Z::$online = Z::$userid > 0 ? true : false;
    }

    function auth($on) {
        self::$onauth = $on;
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

}
