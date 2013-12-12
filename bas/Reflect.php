<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Reflect
 *
 * @author YunPeng
 */
class Reflect {

    static public function run() {
            $classname=Z::$controller;
            $methodname=Z::$action;
            if (!class_exists($classname)) {
                Func::errorMessage("No Class : " . $classname);
            }
            $class = new ReflectionClass($classname);
            if (!$class->hasMethod($methodname)) {
                Func::errorMessage("No Method : " . $classname . '->' . $methodname);
            }
            $instance = $class->newInstance();
            $method = $class->getMethod($methodname);
            $results = $method->invoke($instance);
            return null == $results ? array() : $results;

    }

}
