<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logo
 *
 * @author YunPeng
 */
class login extends Controller {

    function in() {
        $username = Input::text('username');
        $password = Code::encrypt(Input::text('password'));
        $user = DB::table('user')->where("username='$username' and password='$password'")
                ->findOne('userid,roleid,username');
        if (!empty($user)) {
            Cookie::deleteAll();
            Cookie::set('username', $user['username']);
            Cookie::set('userid', $user['userid']);
            Cookie::set('roleid', $user['roleid']);
            Func::jump( URL::web() . 'admin.php');
        } else {
            Html::alert('Sorry');
            Html::jump( URL::web() . 'index.php/login');
        }
        return 'action';
    }

    function out() {
        Cookie::deleteAll();
        Func::jump( URL::web() . 'index.php');
        return 'action';
    }

}
