<?php

class DatabaseSupport {
    protected static $instance=NULL;

    public static function connect($name, array $config=array()) {
        $cf=DatabaseFactory::getInstance();
        if(!empty($config)) {
            $cf->setConfig($config);
        }
        static::$instance=$cf->connect($name);
    }

    public static function disconnect($name) {
        DatabaseFactory::getInstance()->disconnect($name);
        static::$instance=null;
    }

    public static function table($name) {
        return static::$instance->table($name);
    }

    public static function query($sql, array $blind=array()) {
        return static::$instance->query($sql, $blind);
    }

    public static function transaction(Closure $callback) {
        return static::$instance->transaction($callback);
    }

    public static function init(array $dbConfig) {
        DatabaseFactory::getInstance()->setConfig($dbConfig);
    }

    public static function pdo(){
        return static::$instance->pdo();
    }

    public static function log($bool){
        static::$instance->log($bool);
    }

    private static function checkInstance() {
        p(static::$instance);
        if(static::$instance==null){
            echo 'connect DB first';
            exit();
        }
    }
}

