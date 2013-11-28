<?php

class Base {

    static function getThisHost() {
        return
                $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . ':'
                . $_SERVER['SERVER_PORT'] . dirname($_SERVER['SCRIPT_NAME']) . '/';
    }

    static function debug($switch) {
        if ($switch) {
            ini_set('display_errors', 'On');
            error_reporting(E_ALL);
        } else {
            error_reporting(0);
        }
    }

    static function magic() {
        if (!get_magic_quotes_gpc()) {
            $_GET = Str::cleanSql($_GET);
            $_POST = Str::cleanSql($_POST);
            //$_COOKIE = Str::cleanSql($_COOKIE);
        }
    }

}

function p($out) {
    echo "<pre>";
    print_r($out);
    echo "</pre>";
}
