<?php

/**
 * Description of Rediz
 *
 * @author YunPeng
 */
class Rediz {

    static function get($key, $value) {
        if (Z::$redison) {
            $v = Z::$redis->get($key);
            if (empty($v)) {
                Z::$redis->set($key, $value);
                return $value;
            }
            return $v;
        } else {
            return $value;
        }
    }

}
