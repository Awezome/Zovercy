<?php

class Check {

    static function mail($email) {
        return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
    }

            
    static function num($num) {
        return isset($num) ? intval($num) : 0;
    }

    static function isEmpty($data) {
        if (!$data)
            Func::jump(THIS_HOST);
    }

}
