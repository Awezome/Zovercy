<?php

/**
 * Created by PhpStorm.
 * User: YunPeng
 * Date: 4/23/14
 * Time: 10:13 PM
 */
class Model {
    static public function get($modelName=''){
        if($modelName===''){
            $modelName=Z::$controller;
        }
        $name = ucfirst($modelName) . 'Model';
        $dir = SITE_ROOT . 'app/' . Z::$app . '/model/';
        return Factory::getInstance($name, $dir.$name.'.php');
    }

    static public function load(array $data) {
        $dir = SITE_ROOT . 'app/' . Z::$app . '/model/';
        $models = array();
        foreach ($data as $m) {
            $name = ucfirst($m) . 'Model';
            $models[$m] = Factory::getInstance($name, $dir.$name.'.php');
        }
        return $models;
    }
} 