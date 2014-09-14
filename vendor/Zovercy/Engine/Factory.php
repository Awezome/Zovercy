<?php
/**
 * Created by PhpStorm.
 * User: YunPeng
 * Date: 5/3/14
 * Time: 9:37 AM
 */

class Factory {
    private static $ClassBox=array();

    final private function __construct() {
    }

    final private function __clone() {
    }

    public static function getInstance($name,$dir,$flag=''){
        $flagName=$flag.'_'.$name;
        if(isset(self::$ClassBox[$flagName])){
            return self::$ClassBox[$flagName];
        }
        if(file_exists($dir)){
            include $dir;
            $class=new ReflectionClass($name);
            self::$ClassBox[$flagName]=$class->newInstance();
            return self::$ClassBox[$flagName];
        }else{
            return null;
        }
    }
}