<?php

define('CLOUD_ROOT',dirname(__FILE__).'/');
define('SITE_ROOT', dirname(CLOUD_ROOT) . '/');

include CLOUD_ROOT . 'bas/Base.php';
include CLOUD_ROOT . 'bas/Z.php';
include CLOUD_ROOT . 'Config.php';
include CLOUD_ROOT . 'bas/Controller.php';
include CLOUD_ROOT . 'bas/Router.php';
include CLOUD_ROOT . 'bas/Reflect.php';
include CLOUD_ROOT . 'bas/DB.php';
include CLOUD_ROOT . 'bas/Auth.php';

class App {

    private static $onauth = true;
    private static $onredis = false;

    function __construct($source, $theme) {
        Z::$themedir = $theme;
        Z::$sourcedir = $source;

        $this->init();

        Router::run();
        Z::$model = Z::$link . Base::getAppName() . '/' . Z::$controller . '/';
        Z::$db = DB::getInstance(Z::$config['DB']);

        $this->user();
        session_start();
        header('Content-Type:text/html;charset=' . Z::$config['CHARSET']);
    }

    private function init() {
        date_default_timezone_set('PRC'); //设置中国时区
        Z::$link = Base::getLink();
        Z::$theme = Z::$link . Z::$themedir;
        spl_autoload_register("self::_autoload");
        Base::debug(Z::$config['DEBUG']); //开发模式
    }

    public function run() {
        $model = SITE_ROOT . Z::$sourcedir . Z::$controller . '.php';
        if (!is_file($model)) {
            Func::errorMessage("No Controller : " . Z::$sourcedir . Z::$controller);
        }

        if (self::$onauth) {
            Auth::run();
        }

        if (self::$onredis) {
            $this->runRedis();
        }

        include $model;

        Reflect::run();
    }

    static function _autoload($class_name) {
        $class = CLOUD_ROOT . 'lib/' . $class_name . '.php';
        if (is_file($class)) {
            include $class;
        }
    }

    function __destruct() {
        Z::$db->close();
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
