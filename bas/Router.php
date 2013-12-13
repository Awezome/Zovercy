<?php

/*
 * Class Rewrite
 *
 * update : 2012-01-24
 * ----------------------------------------------------------------------*
 * @author : ZYP            @time : 2012-01-24
 * ----------------------------------------------------------------------*
 * Notes :
 *
 * ----------------------------------------------------------------------*
 */

class Router {

    static function run() {
        $name = str_replace(Z::$link, '', Base::getUrl());
        $url = explode("/", $name);
        self::setUpRouter($url);
    }

    static function setUpRouter($arr) {
        Z::$controller = empty($arr[1]) ? 'index' : $arr[1];
        Z::$action = empty($arr[2])?'auto':$arr[2];
        
        $url = array();
        $size = count($arr)-1;
        for ($i = 3; $i < $size; $i++) {
            $url[] = $arr[$i];
        }
        unset($arr);

        Z::$get = $url;  
    }

}
