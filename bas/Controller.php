<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author YunPeng
 */
class Controller {

    private static $path;
    private $data;

    public function __construct() {
        self::$path = SITE_ROOT . Z::$themedir;
    }

    public function __destruct() {
        unset($this->data);
    }

    protected function loadView($page) {
        $p=self::$path . $page . '.html';
        if(!is_file($p)){
            Func::errorMessage('No Template : '. $page );
        }       
        include SITE_ROOT . Z::$sourcedir . '/common.php';
         if (null != $this->data) {
            extract($this->data);
        }
        include self::$path . 'header.html';
        include $p;
        include self::$path . 'footer.html';
    }

    protected function loadSingle($page) {
        $p = self::$path . $page . '.html';
        if (!is_file($p)) {
            Func::errorMessage('No Template : ' . $page);
        }
        include $p;
    }

    protected function setData($data){
        $this->data=$data;        
    }
}
