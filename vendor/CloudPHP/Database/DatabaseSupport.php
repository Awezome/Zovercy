<?php

class DatabaseSupport {
    protected static $instance=NULL;

    public static function connect($name) {
        static::$instance=DatabaseFactory::getInstance()->connect($name);
    }

    public static function disconnect($name='') {
        $size=DatabaseFactory::getInstance()->disconnect($name);
        if($size==0){
            static::$instance=null;
        }
    }

    public static function table($name) {
        self::checkInstance();
        return static::$instance->table($name);
    }

    public static function query($sql, array $blind=array()) {
        self::checkInstance();
        return static::$instance->query($sql, $blind);
    }

    public static function transaction(Closure $callback) {
        self::checkInstance();
        return static::$instance->transaction($callback);
    }

    public static function init(array $dbConfig) {
        DatabaseFactory::getInstance()->setConfig($dbConfig);
    }

    public static function pdo(){
        self::checkInstance();
        return static::$instance->pdo();
    }

    public static function log($bool){
        self::checkInstance();
        static::$instance->log($bool);
    }

    private static function checkInstance() {
        if(static::$instance==null){
            echo 'connect DB first';
            exit();
        }
    }
}

