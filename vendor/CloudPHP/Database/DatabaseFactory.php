<?php

/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/14/14
 * Time: 11:31 AM
 */
class DatabaseFactory {
    private static $config=array();
    private $connectors=array();

    private static $instance=NULL;

    final private function __construct() {
    }

    final private function __clone() {
    }

    function __destruct() {
        self::$instance=NULL;
    }

    final public static function getInstance() {
        if(!(self::$instance instanceof self)) {
            self::$instance=new self();
        }
        return self::$instance;
    }

    private function newConnect($name) {
        if(!isset(self::$config[$name])){
            exit("can't find config database::$name");
        }
        $dbDriver=self::$config[$name]['driver'];
        $con=NULL;
        switch($dbDriver) {
            case 'mysql':
            case 'mariadb':
                $con=new MysqlConnector();
                break;
            case 'sqlite':
                $con==new SQLiteConnector();
            default:
                //coming soon...
                return;
        }
        $con->setConfig(self::$config[$name]);
        $ccc=array('prefix'=>self::$config[$name]['prefix']);
        return new Execution($con, $ccc);
    }

    public function connect($name) {
        if(!array_key_exists($name, $this->connectors)) {
            $this->connectors[$name]=$this->newConnect($name);
        }
        return $this->connectors[$name];
    }

    public function disconnect($name='') {
        if($name==''){
            unset($this->connectors);
            return 0;
        }else{
            if(array_key_exists($name, $this->connectors)) {
                unset($this->connectors[$name]);
            }
            return count($this->connectors);
        }
    }

    public function setConfig($config) {
        self::$config=$config;
    }
}