<?php
include 'bas/Controller.php';
include 'bas/Router.php';
include 'bas/Reflect.php';
include 'bas/DB.php';
define('SITE_ROOT', dirname(dirname(__FILE__)) . '/');
define('THIS_HOST', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['SCRIPT_NAME']) . '/');

class App {

    static private $model;
    static private $page;
    static public $get = array();
    static public $CONFIG;
    static public $db;

    function __construct() {
        include SITE_ROOT . './Cloud/Config.php';
        self::$CONFIG = $CONFIG;
        $this->_define();
        $routerArr = Router::run();
        self::$model = $routerArr['model'];
        self::$page = $routerArr['page'];
        self::$get = $routerArr['gets'];
        include SITE_ROOT . 'Cloud/Lib/function_global.php';

        $this->_class();
        $this->_magic();
        $this->_check();

        self::$db = DB::getInstance();

        session_start();
        header('Content-Type:text/html;charset=' . self::$CONFIG['CHARSET']);
    }

    private function _define() {
        date_default_timezone_set('PRC'); //设置中国时区
        define('DEBUG_MODE', true);                //调试模式开关
        define('NOROBOT', false);                  //限制蜘蛛程序访问开关
        define('THIS_DIR', THIS_HOST . self::$CONFIG['APP']['THEME']);
    }

    public function run() {
        include SITE_ROOT . './' . self::$CONFIG['APP']['CONTROLLER'] . '/common.php';
        include SITE_ROOT . self::$CONFIG['APP']['THEME'] . 'header.html';
        include SITE_ROOT . './' . self::$CONFIG['APP']['CONTROLLER'] . '/' . self::$model . '.php';
        extract(Reflect::run(self::$model, self::$page));
        $page = self::$page == 'auto' ? '' : self::$page;
        include SITE_ROOT . self::$CONFIG['APP']['THEME'] . self::$model . $page . '.html';
        include SITE_ROOT . self::$CONFIG['APP']['THEME'] . 'footer.html';
    }

    private function _magic() {
        if (!get_magic_quotes_gpc()) {
            $_GET = Str::cleanSql($_GET);
            $_POST = Str::cleanSql($_POST);
            //$_COOKIE = Str::cleanSql($_COOKIE);
        }
    }

    private function _check() {
        Debug(); //错误报告
        GetRobot(); //限制蜘蛛程序访问
    }

    private function _class() {
        spl_autoload_register("self::_autoload");
    }

    static function _autoload($class_name) {
        $class_array = array();
        $class_array[] = SITE_ROOT . 'Cloud/lib/' . $class_name . '.php';
        foreach ($class_array as $class) {
            if (is_file($class)) {
                include $class;
            }
        }
    }

}
