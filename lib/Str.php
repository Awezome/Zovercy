<?php

class Str {
    public static function cutStr($data, $cut = 400, $str = ' <span class="radius label">More...</span>') {
        $data = strip_tags($data); //去除html标记
        return mb_strimwidth($data, 0, $cut, $str, "utf-8");
    }

    static function cutStrBack($value, $length = 400) {
        $value = strip_tags($value); //去除html标记  
        $valueEncoding = mb_detect_encoding($value, 'auto', true);
        if ($length >= mb_strwidth($value, $valueEncoding)) {
            return $value;
        }
        $limited = '';
        $firstWidth = ceil($length / 2);
        $secondStart = mb_strwidth($value, $valueEncoding) - ( $length - $firstWidth );
        $secondWidth = $length - $firstWidth + 1;
        $limited = mb_strimwidth($value, 0, $firstWidth, '...', $valueEncoding) . mb_substr($value, $secondStart, $secondWidth, $valueEncoding);
        return $limited;
    }

    public static function comsubstr($string, $length,$charset) {
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
