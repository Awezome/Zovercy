<?php

class post extends Controller {

    function auto() {
        $page = new Page('post', 'pid,title,istop,stats,addtime,ptid,checked','addtime');

        $data=array(
            'newpage' =>$page->run(),
            'results' => $page->sql()
        );        
        $this->setData($data);      
        $this->loadView('postlists');
    }

    function add(){
        $this->edit();
    }

    function edit() {
        $this->loadModel(array('posttype'));
        if (Get::number()==null) {
            $news = array('title' => '', 'excerpt' => '', 'istop' => 0, 'text' => '', 'stats' => '', 'addtime' => date('Y-m-d h:i:s'), 'ptid' => '', 'img' => '', 'submit' => 'Save',);
        } else {
            $newsid = Get::number(0);
            $news = DB::table('post')->where('pid=' . $newsid)->findOne();
            $news['submit'] = 'Update';
        }

        $data = array(
            'news' => $news,
            'postTypes'=>$this->models['posttype']->showPostSelect(null,$news['ptid']),
        );
        $this->setData($data);      
        $this->loadView('postedit');
    }

    function save() {
        $pid=Input::number('pid');

        $set = array(
            'title' =>Input::text('title'),
            'ptid' =>Input::number('id_first'),
            'text' =>Input::get('postedit'),
            'excerpt' =>Input::text('excerpt'),
            'stats' =>Input::number('stats'),
            'addtime' =>Input::get('this_time'),
            //'pid' => $pid
        );
        
        if($pid){
            DB::table('post')->where("pid=" . $pid)->update($set);
            Html::alert('编辑成功');
        }else{
            DB::table('post')->save($set);
            $pid=DB::saveId();
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
