<?php
/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/3/14
 * Time: 3:08 PM
 */

return array(
    'scm' => array(
        'driver'    => 'sqlite',
        'host' => '192.168.1.1',
        'database'  =>'/tmp/remote/db/scm.db',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ),
    'app' => array(
        'driver'    => 'sqlite',
        'database'  =>'/tmp/remote/db/app.db',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ),
    'leanlv' => array(
        'driver'    => 'mysql',
        'host' => '127.0.0.1',
        'database'  =>'learnlv',
        'username'  => 'admin',
        'password'  => 'admin',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ),
    'pdotest' => array(
        'driver'    => 'mysql',
        'host' => '127.0.0.1',
        'database'  =>'pdotest',
        'username'  => 'admin',
        'password'  => 'admin',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ),
);