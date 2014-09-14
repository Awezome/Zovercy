<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Input
 *
 * @author YunPeng
 */
class Input {
    static function get($key) {
        return $_POST[$key];
    }

    static function getAll() {
        return $_POST;
    }

    static function has($key) {
        return Check::exist($_POST[$key]);
    }

    static function text($key) {
        return isset($_POST[$key])?Check::text($_POST[$key]):'';
    }

    static function number($key) {
        return isset($_POST[$key])?Check::number($_POST[$key]):0;
    }

    static function datetime() {
        
    }

}
