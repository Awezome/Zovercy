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
        $name = str_replace( Base::getLink(), '', Base::getUrl());
        $url = explode("/", $name);
        return self::setUpRouter($url);
    }

    static function setUpRouter($arr) {
        $url = array();
        $size = count($arr) - 1;
        for ($i = 3; $i < $size; $i++) {
            $url[] = $arr[$i];
        }
       $rarray=array();
        if (empty($arr[2])) {
            $rarray=array('controller' =>'', 'action' => 'auto', 'get' => '');
            $rarray['controller']=empty($arr[1])?'index':$arr[1];            
        } else {
            $rarray=array('controller' => $arr[1], 'action' => $arr[2], 'get' => $url);
        }
        return $rarray;
    }

}
