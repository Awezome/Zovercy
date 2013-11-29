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

}

function p($out='') {
    echo "<pre>";
    print_r($out);
    echo "</pre>";
}
