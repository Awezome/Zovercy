<?php

return array(
    'default' => array(
        'driver'    => 'mysql',             //数据库类型
        'host' => '127.0.0.1',              //数据库地址
        'database'  =>'cloudphp',           //数据库名
        'username'  => 'cloudphp',              //数据库用户名
        'password'  => 'cloudphp',         // 数据库密码
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => 'cloudphp',          // 表前缀
        'timezone'  => '+8:00',
    ),
    'sqlite' => array(
        'driver'    => 'sqlite',
        'host' => '192.168.1.1',
        'database'  =>'/tmp/remote/db/scm.db',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ),
);