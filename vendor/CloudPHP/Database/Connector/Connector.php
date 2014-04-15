<?php
/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/4/14
 * Time: 11:57 AM
 */

abstract class Connector {
    protected static $config=array();

    protected $option = array(
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    public function createConnector($dsn, array $config, array $option){
        $username=$config['username'];
        $password=$config['password'];
        return new PDO($dsn,$username,$password,$this->option);
    }

    public function setConfig($config){
        self::$config=$config;
    }

    abstract protected function getDsn(array $config);
}