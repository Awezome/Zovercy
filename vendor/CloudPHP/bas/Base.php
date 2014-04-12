<?php

class Base {

    static function getLink() {
        return self::getHost() . dirname($_SERVER['SCRIPT_NAME']) . '/';
    }

    static function getHost(){
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'];
        //return Z::$config['WEBSITE']['DOMAIN'];
    }

    static function getUrl(){
        return self::getHost().$_SERVER['REQUEST_URI'];
    }

    static function getWebDir(){
        //$dir=dirname($_SERVER['SCRIPT_NAME']);
        //$dir=$dir=='\\'?'/':$dir;
        return Z::$config['WEBSITE']['DIR'];
    }
    
    static function debug($switch) {
        if ($switch) {
            ini_set('display_errors', 'On');
            error_reporting(E_ALL);
        } else {
            error_reporting(0);
        }
    }

}
