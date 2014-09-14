<?php
/**
 * Created by PhpStorm.
 * User: YunPeng
 * Date: 5/3/14
 * Time: 10:22 AM
 */

class View {
    static function load($viewName,array $data=array()){
        $path=SITE_ROOT.'app/'.Z::$app.'/';
        $page=$viewName==null?Z::$controller:$viewName;
        include $path. 'model/commondata.php';
        $p=$path .'view/'.$page . '.html';
        if(!is_file($p)){
            Func::errorMessage('No Template : '. $page );
        }
        if (null != $data) {
            extract($data);
        }
        include $path . 'view/header.html';
        include $p;
        include $path . 'view/footer.html';
    }

    static function page($viewName,array $data=array()){
        $path=SITE_ROOT.'app/'.Z::$app.'/';
        $page=$viewName==null?Z::$controller:$viewName;
        $p=$path .'view/'.$page . '.html';
        if(!is_file($p)){
            Func::errorMessage('No Template : '. $page );
        }
        if (null != $data) {
            extract($data);
        }
        include $p;
    }
} 