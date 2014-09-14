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
    static private $path='/'; //to do : it will delete all cookies in the domain

    static function set($name, $value) {
        self::getConfig();
        $name = Code::encrypt($name,self::$config['KEY']);
        $value = Code::encode($value,self::$config['KEY']); 
        setcookie($name, $value, time() + self::$config['TIME'],self::$path);
    }

    static function get($name) {
        self::getConfig();
        $nameTemp = Code::encrypt($name,self::$config['KEY']);
        return isset($_COOKIE[$nameTemp]) ? Code::decode($_COOKIE[$nameTemp],self::$config['KEY']) : null;
    }

    static function delete($name) {
        self::getConfig();
        $name = Code::encrypt($name,self::$config['KEY']);
        setcookie($name, null ,-1,self::$path);
    }

    static function deleteAll() {
        while ($key = key($_COOKIE)) {
            setcookie($key, null, -1,self::$path);
            next($_COOKIE);
        }
    }

    static private function getConfig(){
        self::$config = Z::$config['COOKIE'];
        self::$path=Base::getWebDir();
    }
    
}
