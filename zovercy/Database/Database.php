<?php

namespace Zovercy\Database;
use Illuminate\Database\Capsule\Manager;

class Database
{
    public function __construct()
    {
        $database = [
            'driver' => 'mysql',
            'host' => $dbconfig['host'],
            'database' => $dbconfig['database'],
            'username' => $dbconfig['username'],
            'password' => $dbconfig['password'],
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ];
        $Capsule = new Manager();
        $Capsule->addConnection($database);
        $Capsule->setAsGlobal();
        $Capsule->bootEloquent();
    }
}
