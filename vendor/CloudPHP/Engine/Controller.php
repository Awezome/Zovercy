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
    protected $model=null;
    private static $path;
    private $data;

    public function __construct() {
        self::$path=SITE_ROOT.'app/'.Z::$app.'/';
        $this->loadModel(Z::$controller);
    }

    public function __destruct() {
        unset($this->data);
    }

    protected function loadView($page) {
        include self::$path. 'model/commondata.php';
        $p=self::$path .'view/'.$page . '.html';
        if(!is_file($p)){
            Func::errorMessage('No Template : '. $page );
        }
                 
         if (null != $this->data) {
            extract($this->data);
        }
        include self::$path . 'view/header.html';
        include $p;
        include self::$path . 'view/footer.html';
    }

    protected function loadSingle($page) {
        $p = self::$path .'view/'. $page . '.html';
        if (!is_file($p)) {
            Func::errorMessage('No Template : ' . $page);
        }

        if (null != $this->data) {
            extract($this->data);
        }
        include $p;
    }

    protected function setData($data){
        $this->data=$data;        
    }
	
    protected function json($str) {
        echo json_encode($str);
    }

    private function loadModel($filename){
        $name=ucfirst($filename).'Model';
        $model=self::$path. 'model/'.$name.'.php';
        if(file_exists($model)){
            include $model;
            $class=new ReflectionClass($name);
            $this->model= $class->newInstance();
        }
    }

}
