<?php

class catalog extends Controller {

    public function show() {
        $ps=Get::string(0);
        $pp=DB::table('posttype')->where("cname='$ps'")->findOne('ptid');
        $t=Check::number($pp['ptid']);
        $where = "ptid=" . $t;
        $p = new Page('post', 'pid,title,text,istop,stats,addtime,ptid,checked', 'addtime',$where,10);

        $data=array(
            'newsAlls' => $p->sql(),
            'build_page' => $p->run(),
            'navname'=>$ps,
            'postlist'=>true
        );
        $this->setData($data);
        $this->loadView('postlists');
    }
}
