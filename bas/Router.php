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
        $url = array();
        $size = count($arr) - 1;
        for ($i = 3; $i < $size; $i++) {
            $url[] = $arr[$i];
        }
        if (empty($arr[2])) {
            Z::$controller = '';
            Z::$action = 'auto';
            Z::$get = '';

            Z::$controller = empty($arr[1]) ? 'index' : $arr[1];
        } else {
            Z::$controller = $arr[1];
            Z::$action = $arr[2];
            Z::$get = $url;
        }
    }

}
