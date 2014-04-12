<?php

/**
 * Class Code
 *
 * update : 2013-05-29
 * ----------------------------------------------------------------------*
 * @improve : ZYP            @time : 2012-01-11
 */
class Code {

    static function encode($string, $key = 'cloudphp') {
        $encrypt_key = md5(rand(0, 320000000));
        $encrypt_key_length = 32;
        $ctr = 0;
        $tmp = "";
        $string_l = strlen($string);
        for ($i = 0; $i < $string_l; $i++) {
            if ($ctr == $encrypt_key_length)
                $ctr = 0;
            $code = substr($encrypt_key, $ctr, 1);
            $tmp.= $code . (substr($string, $i, 1) ^ $code);
            $ctr++;
        }
        return base64_encode(self::keycode($tmp, $key));
    }

    static function decode($str, $key = 'cloudphp') {
        $string =self::keycode(base64_decode($str), $key);
        $tmp = "";

        $string_l = strlen($string);
        for ($i = 0; $i < $string_l; $i+=2) {
            $code = substr($string, $i, 1);
            $codeplus = substr($string, $i + 1, 1);
            $tmp.= ($codeplus ^ $code);
        }
        return $tmp;
    }

    static private function keycode($string, $encrypt_key) {
        $encrypt_key = md5($encrypt_key);
        $ctr = 0;
        $tmp = "";
        $string_l = strlen($string);
        $encrypt_key_length = 32;
        for ($i = 0; $i < $string_l; $i++) {
            if ($ctr == $encrypt_key_length)
                $ctr = 0;
            $tmp.= substr($string, $i, 1) ^ substr($encrypt_key, $ctr, 1);
            $ctr++;
        }
        return $tmp;
    }

    public static function encrypt($string,$key = 'cloudphp') {
        return md5(md5($string) . substr($string, 0, 4).$key);
    }

}
