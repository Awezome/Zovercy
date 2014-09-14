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
        if(isset($arr[3])||(isset($arr[2])&&empty($arr[2]))||(isset($arr[1])&&empty($arr[1]))){
            if(empty($arr[2])){
                Z::$action='auto';
            }else{
                Z::$action=$arr[2];
            }
        }else{
            Z::$action='show';
            $flag=2;
        }

        if(isset($arr[2])){
            if(empty($arr[1])){
                Z::$controller='index';
            }else{
                Z::$controller=$arr[1];
            }
        }else{
            Z::$controller ='index';
            $flag=1;
        }

        Z::$app=empty($arr[0]) ? 'index' : $arr[0];

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
