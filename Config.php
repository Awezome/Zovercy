<?php

$CONFIG['DB'] = array(
    'TYPE' => 'mysql', //数据库类型
    'HOST' => '127.0.0.1', //数据库地址
    'NAME' => '', //数据库名
    'USER' => '', //数据库用户名
    'PWD' => '', // 数据库密码
    'TABLEPRE' => 'hisunphp_', // 表前缀
    'CHARSET' => 'utf8', // MySQL 字符集, 可选 'gbk', 'big5', 'utf8', 'latin1', 留空为按照默认字符集设定
);

// Cookie
$CONFIG['COOKIE'] = array(
    'PRE' => 'hisunphp', //cookie 前缀,建议更改
    'KEY' => 'hisunphp', //cookie 加密密钥，加密使用，建议更改
    'TIME' => 120000, //Cookie过期时间，单位秒
);

$CONFIG['APP'] = array(
    'CONTROLLER' => 'source',
    'THEME' => 'theme/default/',
    'ADMIN' => 'admin/view/',
);

$CONFIG['CHARSET'] = 'utf-8'; // 'gbk', 'big5', 'utf-8'