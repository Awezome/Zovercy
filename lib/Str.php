<?php

class Str {

    public static function comsubstr($string, $length) {
        $length1 = mb_strlen($string, $charset);
        if ($length >= $length1) {
            return $string;
        } else {
            $string = mb_substr($string, 0, $length - 3, $charset);
            $string.='...';
            return $string;
        }
    }

    static function cleanJs($js) {
        return preg_replace("'<script[^>]*?>.*?</script>'si", '', $js);
    }

    public static function strexists($haystack, $needle) {
        return !(strpos($haystack, $needle) === FALSE);
    }

    public static function NoRand($begin, $end, $limit = 9) {
        $rand_array = range($begin, $end);
        shuffle($rand_array); //调用现成的数组随机排列函数
        return array_slice($rand_array, 0, $limit); //截取前$limit个
    }

//产生不重复的数字

    static function random($length, $numeric = 0) {
        PHP_VERSION < '4.2.0' ? mt_srand((double) microtime() * 1000000) : mt_srand();
        $seed = base_convert(md5(print_r($_SERVER, 1) . microtime()), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
        $hash = '';
        $max = strlen($seed) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $seed[mt_rand(0, $max)];
        }
        return $hash;
    }

//产生随机字符//$length：要产生的随机字符串长度 $numeric：	是否为纯数字，当为0是表示非纯数字
}
