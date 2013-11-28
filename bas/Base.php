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
            function addslashesDeep($var) {
                return is_array($var) ? array_map('addslashesDeep', $var) : addslashes($var);
            }
            $_GET = addslashesDeep($_GET);
            $_POST = addslashesDeep($_POST);
            //$_COOKIE = addslashesDeep($_COOKIE);
            //$_REQUEST = addslashesDeep($_REQUEST);
        }
    }
}

function p($out) {
    echo "<pre>";
    print_r($out);
    echo "</pre>";
}
