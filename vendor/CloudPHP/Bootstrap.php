<?php
/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/16/14
 * Time: 12:53 PM
 */

define('SITEROOT',__DIR__.'/');
include SITEROOT.'Helper/Basic.php';
$dbConfig=include 'config.php';

function __autoload($className) {
    $map=load::map();
    if(array_key_exists($className,$map)){
        include SITEROOT.$map[$className].$className.'.php';
    }else{
        die("Unable to load $className.");
    }
}

class load{
    private static $map=array();
    final public static function map() {
        if(empty(self::$map)) {
            self::$map=include SITEROOT.'Engine/Map.php';
        }
        return self::$map;
    }
}
