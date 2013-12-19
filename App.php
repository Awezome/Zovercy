<?php

define('SITE_ROOT', dirname(dirname(__FILE__)) . '/');
include SITE_ROOT . './Cloud/bas/Base.php';
include SITE_ROOT . './Cloud/bas/Z.php';
include SITE_ROOT . './Cloud/Config.php';
include SITE_ROOT . './Cloud/bas/Controller.php';
include SITE_ROOT . './Cloud/bas/Router.php';
include SITE_ROOT . './Cloud/bas/Reflect.php';
include SITE_ROOT . './Cloud/bas/DB.php';
include SITE_ROOT . './Cloud/bas/Auth.php';

class App {
    function __construct($source, $theme) {
        Z::$themedir=$theme;
        Z::$sourcedir=$source;
        
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
        Z::$theme= Z::$link .Z::$themedir;
        spl_autoload_register("self::_autoload");
        Base::debug(Z::$config['DEBUG']); //开发模式
    }

    public function run() {        
        $model = SITE_ROOT .  Z::$sourcedir . Z::$controller . '.php';
        if (!is_file($model)) {
            Func::errorMessage("No Controller : " .  Z::$sourcedir . Z::$controller);
        }
        Auth::run();
                            
        include $model;
       
        Reflect::run();

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
