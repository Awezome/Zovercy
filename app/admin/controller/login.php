<?php
/**
 * Description of logo
 *
 * @author YunPeng
 */
class login extends Controller {
    function auto(){
        $this->loadPage('login');
    }

    function in() {
        $username = Input::text('username');
        $password = Code::encrypt(Input::text('password'));
        $user = DB::table('user')->where('username=? and password=?',array($username,$password))
                ->findOne('userid,roleid,username');

        if (!empty($user)) {
            Cookie::deleteAll();
            Cookie::set('username', $user['username']);
            Cookie::set('userid', $user['userid']);
            Cookie::set('roleid', $user['roleid']);
            jump( URL::app());
        } else {
            Html::alert('Sorry');
            Html::jump( URL::controller());
            exit();
        }
    }

    function out() {
        Cookie::deleteAll();
        jump( URL::controller());
    }

}
