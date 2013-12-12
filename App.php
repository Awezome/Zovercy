<?php

define('SITE_ROOT', dirname(dirname(__FILE__)) . '/');
include 'bas/Base.php';
include 'bas/Z.php';
include SITE_ROOT . './Cloud/Config.php';
include 'bas/Controller.php';
include 'bas/Router.php';
include 'bas/Reflect.php';
include 'bas/DB.php';
include 'bas/Auth.php';

class App {
    static private $_source;
    static private $_theme;

    function __construct($source, $theme) {
        self::$_source = $source;
        self::$_theme = $theme;
        
        $this->init();

        Router::run();
        Z::$model=Z::$link.Base::getAppName().'/'.Z::$controller.'/';
        Z::$db = DB::getInstance(Z::$config['DB']);

        $this->user();
        session_start();
        header('Content-Type:text/html;charset=' . Z::$config['CHARSET']);
    }

    private function init() {
        date_default_timezone_set('PRC'); //设置中国时区
        Z::$link=Base::getLink();
        Z::$theme= Z::$link . self::$_theme;
        spl_autoload_register("self::_autoload");
        Base::debug(Z::$config['DEBUG']); //开发模式
    }

    public function run() {
        $model = SITE_ROOT . self::$_source . Z::$controller . '.php';
        if (!is_file($model)) {
            Func::errorMessage("No Controller : " . self::$_source . Z::$controller);
        }
        
        Auth::run();
        
        include $model;
        $end = Reflect::run();
        if ('action' == $end) {
            exit();
        }
        include SITE_ROOT . self::$_source . '/common.php';
        include SITE_ROOT . self::$_theme . 'header.html';
        include SITE_ROOT . self::$_theme . 'sidebar.html';
        if (null != $end) {
            extract($end);
        }
        $page = Z::$action == 'auto' ? '' : Z::$action;
        include SITE_ROOT . self::$_theme .Z::$controller . $page . '.html';
        include SITE_ROOT . self::$_theme . 'footer.html';
        exit();
    }

    static function _autoload($class_name) {
        $class = SITE_ROOT . 'Cloud/lib/' . $class_name . '.php';
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
        Z::$online=Z::$userid>0?true:false;
    }

}
