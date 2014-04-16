<?php

/**
 * Created by PhpStorm.
 * User: YunPeng
 * Date: 4/13/14
 * Time: 3:33 PM
 */
class URL {
    public static function app() {
        return self::web() . Z::$app . '/';
    }

    public static function controller() {
        return self::app() . Z::$controller . '/';
    }

    public static function action() {
        return self::controller() . Z::$action . '/';
    }

    public static function web(){
        return Base::getHost() . dirname($_SERVER['SCRIPT_NAME']) . '/';
    }

    public static function link($app='') {
        if($app==''){
            $app=Z::$app;
        }
        echo self::web().'public/'.$app.'/';
    }
} 