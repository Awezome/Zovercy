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
        $name = str_replace($_SERVER["SCRIPT_NAME"], "", $_SERVER["REQUEST_URI"]);
        $url = explode("/", $name);
        return self::setUpRouter($url);
    }

    static function setUpRouter($arr) {
        $url = array();
        $size = count($arr) - 1;
        for ($i = 3; $i < $size; $i++) {
            $url[] = $arr[$i];
        }
        if (empty($arr[2])) {
            return array('model' => 'index', 'page' => 'auto', 'gets' => '');
        } else {
            return array('model' => $arr[1], 'page' => $arr[2], 'gets' => $url);
        }
    }

}
