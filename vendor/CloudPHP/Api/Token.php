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

    static public function check($msg='wrong token'){
        $session=Session::get('token');
        Session::set('token',0);
        $input=Input::text('taketoken');
        if($session==$input){
            return true;
        }else{
            Html::alert($msg);
            exit();
        }
    }
} 