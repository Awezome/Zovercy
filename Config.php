<?php

$CONFIG['DB'] = array(
    'TYPE' => 'mysql', //数据库类型
    'HOST' => '127.0.0.1', //数据库地址
    'NAME' => 'cloudphp', //数据库名
    'USER' => 'cloudphp', //数据库用户名
    'PWD' => 'cloudphp', // 数据库密码
    'TABLEPRE' => 'cloudphp', // 表前缀
    'CHARSET' => 'utf8', // MySQL 字符集, 可选 'gbk', 'big5', 'utf8', 'latin1', 留空为按照默认字符集设定
    'TIMEZONE'=>'+8:00' //时区
);

// Cookie
$CONFIG['COOKIE'] = array(
    'KEY' => 'cloudphp', //cookie 加密密钥，加密使用，建议更改
    'TIME' => 120000, //cookie过期时间，单位秒
);

$CONFIG['CHARSET'] = 'utf-8'; // 'gbk', 'big5', 'utf-8'