<?php
/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/14/14
 * Time: 11:31 AM
 */
include SITEROOT.'Database/Connection/Connection.php';
include SITEROOT.'Database/Connector/Connector.php';
include SITEROOT.'Database/Connector/ConnectorInterface.php';
include SITEROOT.'Database/Connector/MysqlConnector.php';
include SITEROOT.'Database/Connector/SQLiteConnector.php';

class ConnectFactory {
    private static $config=array();
    private $connectors=array();

    private static $instance=null;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance(){
        if(!(self::$instance instanceof self)){
            self::$instance=new self();
        }
        return self::$instance;
    }

    private function newConnect($name) {
        $dbDriver=self::$config[$name]['driver'];
        $con=null;
        switch ($dbDriver){
            case 'mysql':
                $con= new MysqlConnector();
                break;
            case 'sqlite':
                $con== new SQLiteConnector();
            default:
                return;
        }
        $con->setConfig(self::$config[$name]);

        $c=new Connection();
        $c->setConnector($con);
        return $c;
    }

    public function connect($name){
        if(!array_key_exists($name,$this->connectors)){
            $this->connectors[$name]=$this->newConnect($name);
        }else {}
        return $this->connectors[$name];
    }

    public function setConfig($config){
        self::$config=$config;
    }
}