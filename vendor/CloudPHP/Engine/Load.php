<?php
/**
 * Created by PhpStorm.
 * User: YunPeng
 * Date: 4/16/14
 * Time: 9:22 PM
 */

class Load {
    private static $map=array();
    final public static function map() {
        if(empty(self::$map)) {
            self::$map=include CLOUD_ROOT.'Engine/Map.php';
        }
        return self::$map;
    }
}