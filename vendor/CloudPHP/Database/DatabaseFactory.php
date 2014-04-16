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

    function __destruct(){
        self::$instance=null;
    }

    final public static function getInstance() {
        if(!(self::$instance instanceof self)) {
            self::$instance=new self();
        }
        return self::$instance;
    }

    private function newConnect($name) {
        $dbDriver=self::$config[$name]['driver'];
        $con=NULL;
        switch($dbDriver) {
            case 'mysql':
                $con=new MysqlConnector();
                break;
            case 'sqlite':
                $con==new SQLiteConnector();
            default:
                return;
        }
        $con->setConfig(self::$config[$name]);
        $c=new Execution();
        $c->setConnector($con);
        return $c;
    }

    public function connect($name) {
        if(!array_key_exists($name, $this->connectors)) {
            $this->connectors[$name]=$this->newConnect($name);
        }
        return $this->connectors[$name];
    }

    public function disconnect($name) {
        if(array_key_exists($name, $this->connectors)) {
            $this->connectors[$name]=NULL;
            unset($this->connectors[$name]);
        }
    }

    public function setConfig($config) {
        self::$config=$config;
    }

}