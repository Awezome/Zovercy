<?php

class index extends Controller {

    public function auto() {
        $p = new Page('post', 'pid,title,text,istop,stats,addtime,ptid,checked,uid', 'addtime','1=1',10);

       $data=array(
            'newsAlls' => $p->sql(),
            'build_page' => $p->run()
        );        
        View::load('postlists',$data);
    }

}
