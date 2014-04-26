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
        return Check::filterNeed() ? Check::filterArray($_POST[$key]) : $_POST[$key];
    }

    static function getAll() {
        return Check::filterNeed() ? Check::filterArray($_POST) : $_POST;
    }

    static function has($key) {
        return Check::exist($_POST[$key]);
    }

    static function text($key) {
        if(isset($_POST[$key])){
            return Check::text(Check::filterNeed() ? Check::filter($_POST[$key]) : $_POST[$key]);
        }else{
            return '';
        }
    }

    static function number($key) {
        return isset($_POST[$key])?Check::number($_POST[$key]):0;
    }

    static function datetime() {
        
    }

}
