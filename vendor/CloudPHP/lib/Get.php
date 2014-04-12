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
        return empty(Z::$get) ? null : Check::filterNeed() ? Check::filterArray(Z::$get) : Z::$get;
    }

    static function string($key = 0) {
        return empty(Z::$get) ? null : Check::text(Check::filterNeed() ? Check::filter(Z::$get[$key]) : Z::$get[$key]);
    }

    static function number($key = 0) {
        return empty(Z::$get) ? null : Check::number(Z::$get[$key]);
    }

}
