<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Get
 *
 * @author YunPeng
 */
class Get {
    static function all() {
        return empty(App::$get) ? null : Check::filterNeed() ? Check::filterArray(App::$get) : App::$get;
    }

    static function string($key = 0) {
        return empty(App::$get) ? null : Check::text(Check::filterNeed() ? Check::filter(App::$get[$key]) : App::$get[$key]);
    }

    static function number($key = 0) {
        return empty(App::$get) ? null : Check::number(App::$get[$key]);
    }

}
