<?php

class Base{
    static public function getThisHost(){
        return
            $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . ':' 
            . $_SERVER['SERVER_PORT'] . dirname($_SERVER['SCRIPT_NAME']) . '/';
    }
}

    function GetRobot() {
        if (!defined('IS_ROBOT')) {
            $kw_spiders = 'Bot|Crawl|Spider|slurp|sohu-search|lycos|robozilla';
            $kw_browsers = 'MSIE|Netscape|Opera|Konqueror|Mozilla';
            if (!Str::strexists($_SERVER['HTTP_USER_AGENT'], 'http://') && preg_match("/($kw_browsers)/i", $_SERVER['HTTP_USER_AGENT'])) {
                define('IS_ROBOT', FALSE);
            } elseif (preg_match("/($kw_spiders)/i", $_SERVER['HTTP_USER_AGENT'])) {
                define('IS_ROBOT', TRUE);
            } else {
                define('IS_ROBOT', FALSE);
            }
        }
        if (defined('NOROBOT') && IS_ROBOT)
            exit(header("HTTP/1.1 403 Forbidden"));
    }
    
    
    function Debug() {
        if (DEBUG_MODE) {
            ini_set('display_errors', 'On');
            error_reporting(E_ALL);
        } else {
            error_reporting(0);
        }
    }
