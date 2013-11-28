<?php
define('SITE_ROOT', dirname(dirname(__FILE__)) . '/');
include 'bas/Controller.php';
include 'bas/Router.php';
include 'bas/Reflect.php';
include 'bas/DB.php';
include 'bas/Base.php';
define('THIS_HOST', Base::getThisHost());

class App {
    static private $model;
    static private $page;
    static public $get = array();
    static public $CONFIG;
    static public $db;
    
    static private $_source;
    static private $_theme;
    
    static public $gid=1;
    static public $uid=1;

    function __construct($source,$theme) {
        include SITE_ROOT . './Cloud/Config.php';
        self::$CONFIG = $CONFIG;
        
        self::$_source=$source;
        self::$_theme=$theme;        
        
        $routerArr = Router::run();
        self::$model = $routerArr['model'];
        self::$page = $routerArr['page'];
        self::$get = $routerArr['gets'];        

        $this->_define();        
        $this->_class();
        $this->_magic();
        $this->_check();
        
        self::$db = DB::getInstance(self::$CONFIG['DB']);

        session_start();
        header('Content-Type:text/html;charset=' . self::$CONFIG['CHARSET']);
    }

    private function _define() {
        date_default_timezone_set('PRC'); //设置中国时区
        define('DEBUG_MODE', true);                //调试模式开关
        define('NOROBOT', false);                  //限制蜘蛛程序访问开关
        define('THIS_DIR', THIS_HOST . self::$_theme);
    }

    public function run() {
        $model= SITE_ROOT . self::$_source  . self::$model . '.php';
        if(is_file($model)){
            include $model; 
        }else{
            Func::errorMessage("No File : " .  self::$_source  . self::$model . '.php');
        }
        $end=Reflect::run(self::$model, self::$page);
        if('action'==$end){
            exit();
        }
        include SITE_ROOT . self::$_source . '/common.php';
        include SITE_ROOT . self::$_theme . 'header.html';
        include SITE_ROOT . self::$_theme . 'sidebar.html';
        if(null!=$end){
            extract($end);
            $page = self::$page == 'auto' ? '' : self::$page;
            include SITE_ROOT . self::$_theme . self::$model . $page . '.html';
        }
        include SITE_ROOT . self::$_theme . 'footer.html';
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
        $class = SITE_ROOT . 'Cloud/lib/' . $class_name . '.php';
        if (is_file($class)) {
            include $class;
        }
    }

    function __destruct() {
        self::$db->close();
    }
}
