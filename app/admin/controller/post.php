<?php

class post extends Controller {

    function auto() {
        $page = new Page('post', 'pid,title,istop,stats,addtime,ptid,checked','addtime');

        $data=array(
            'newpage' =>$page->run(),
            'results' => $page->sql()
        );        
        View::load('postlists',$data);
    }

    function add(){
        $this->edit();
    }

    function edit() {
        if (Get::number()==null) {
            $news = array('title' => '', 'excerpt' => '', 'istop' => 0, 'text' => '', 'stats' => '', 'addtime' => date('Y-m-d h:i:s'), 'ptid' => '', 'img' => '', 'submit' => 'Save',);
        } else {
            $newsid = Get::number(0);
            $news = DB::table('post')->where('pid=' . $newsid)->findOne();
            $news['submit'] = 'Update';
        }

        $data = array(
            'news' => $news,
            'postTypes'=>Model::get('posttype')->showPostSelect(null,$news['ptid']),
        );
        View::load('postedit',$data);
    }

    function save() {
        $pid=Input::number('pid');

        $set = array(
            'title' =>Input::text('title'),
            'ptid' =>Input::number('posttype'),
            'excerpt' =>Input::text('excerpt'),
            'stats' =>Input::number('stats'),
            'addtime' =>Input::get('this_time'),
            'text' =>Input::get('postedit'),
        );

        if($pid){
            DB::table('post')->where("pid=" . $pid)->update($set);
            Html::alert('编辑成功');
        }else{
            $pid=DB::table('post')->save($set);
            Html::alert('添加成功');
        }

        Html::jump( URL::controller() . 'edit/' . $pid . '/');
    }

    function delete(){
        $pid =Get::number(0);
        DB::table('post')->where('pid='.$pid)->delete();
        Html::jump( URL::web() . 'admin.php/post/lists/');
    }

    function show(){}

}
