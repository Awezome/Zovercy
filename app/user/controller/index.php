<?php

class index extends Controller {

    public function auto() {
        jump('../blog/');
    }

    public function show(){
        $uname=Get::string(0);
        $userid=DB::table('user')->where('username=?',array($uname))->GetOne('userid');

        $p = new Page('post', 'pid,title,text,istop,stats,addtime,ptid,checked', 'addtime','uid='.$userid,10);

        $data=array(
            'newsAlls' => $p->sql(),
            'build_page' => $p->run(),
            'uname'=>$uname,
        );
        View::load('postlists',$data);
    }

}
