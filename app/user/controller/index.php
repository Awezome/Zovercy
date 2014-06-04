<?php

class index extends Controller {

    public function auto() {
        jump('../blog/');
    }

    public function show(){
        $uname=Get::string(0);
        $user=DB::table('user')->where('username=?',array($uname))->findOne('userid,template');
        $userid=$user['userid'];
        $p = new Page('post', 'pid,title,text,istop,stats,addtime,ptid,checked', 'addtime','uid='.$userid,10);

        $data=array(
            'newsAlls' => $p->sql(),
            'build_page' => $p->run(),
            'uname'=>$uname,
        );
        //get template page
        $page=$user['template']==''?'found':$user['template'];
        View::page($page,$data);
    }

}
