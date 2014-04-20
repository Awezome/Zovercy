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
        $name = str_replace(URL::web(), '', Base::getUrl());
        $url = explode("/", $name);
        self::setUpRouter($url);
    }

    static function setUpRouter($arr) {
        $flag=3;
        Z::$app=empty($arr[0]) ? 'index' : $arr[0];
        Z::$controller = empty($arr[1]) ? 'index' : $arr[1];
        Z::$action = empty($arr[2])?'auto':$arr[2];

        if(!isset($arr[2])&&isset($arr[1])){
            Z::$controller ='index';
        }

        if(!isset($arr[3])&&isset($arr[2])){
            Z::$action ='show';
            $flag=2;
        }

        $url = array();
        $size = count($arr);
        for ($i = $flag; $i < $size; $i++) {
            if(!empty($arr[$i])){
                $url[] = $arr[$i];
            }
        }
        unset($arr);
        Z::$get = $url;
    }
}
