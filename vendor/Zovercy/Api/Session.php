<?php
/**
 * Created by PhpStorm.
 * User: YunPeng
 * Date: 5/3/14
 * Time: 6:46 PM
 */

class Session {

    static function set($name, $value) {
        $_SESSION[Code::encrypt($name)]=Code::encode($value);
    }

    static function get($name) {
        return Code::decode($_SESSION[Code::encrypt($name)]);
    }

    static function delete($name) {
        unset($_SESSION[Code::encrypt($name)]);
    }

    static function deleteAll() {
        session_destroy();
    }
}