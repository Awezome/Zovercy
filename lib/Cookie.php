<?php

/*
 * Class Cookie
 *
 * update : 2013-11-29
 * ----------------------------------------------------------------------*
 * @author : ZYP            @time : 2012-01-11
 * ----------------------------------------------------------------------*
 * Notes :
 *
 * $c = new Cookie (l);
 * $c -> set_cookie ($name , $value);		// setcookie
 * $c -> get_cookie ($name);		// getcookie
 * $c -> del_all_cookie ();		// delete all cookie in the websites
 * ----------------------------------------------------------------------*
 */

class Cookie {

    static private $config = array();

    static function set($name, $value) {
        self::getConfig();
        $name = Code::encrypt($name,self::$config['KEY']);
        $value = Code::encode($value,self::$config['KEY']); //调用父类的方法
        setcookie($name, $value, time() + self::$config['TIME']);
    }

    static function get($name) {
        self::getConfig();
        $nameTemp = Code::encrypt($name,self::$config['KEY']);
        return isset($_COOKIE[$nameTemp]) ? Code::decode($_COOKIE[$nameTemp],self::$config['KEY']) : null;
    }

    static function delete($name) {
        self::getConfig();
        $name = Code::encrypt($name,self::$config['KEY']);
        setcookie($name, null , time() - 3600);
    }

    static function deleteAll() {
        while ($key = key($_COOKIE)) {
            setcookie($key, null, time() - 3600);
            next($_COOKIE);
        }
    }

    static private function getConfig(){
        self::$config = APP::$CONFIG['COOKIE'];
    }
    
}
