<?php
/**
 * Created by PhpStorm.
 * User: YunPeng
 * Date: 5/3/14
 * Time: 6:24 PM
 */

class Token {
    static public function run(){
        $key=Code::encrypt(microtime(true));
        Session::set('token',$key);
        Session::set('tokenrun',time());
        echo '<input type="hidden" name="taketoken" value="'.$key.'" />';
    }

    static public function init(){
        Session::set('token',md5(time()));
    }

    static public function check($msg='wrong token'){
        $session=Session::get('token');
        self::init();
        $input=Input::text('taketoken');
        if($session==$input){
            return true;
        }else{
            Html::alert($msg);
            exit();
        }
    }
} 