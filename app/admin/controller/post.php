<?php

class post extends Controller {

    function lists() {
        $page = new Page('post', 'pid,title,istop,stats,addtime,ptid,checked','addtime'); 

        $data=array(
            'newpage' =>$page->run(),
            'results' => $page->sql()
        );        
        $this->setData($data);      
        $this->loadView('postlists');
    }

    function edit() {
        if (Get::number()==null) {
            $news = array('title' => '', 'excerpt' => '', 'istop' => 0, 'text' => '', 'stats' => '', 'addtime' => date('Y-m-d h:i:s'), 'ptid' => '', 'img' => '', 'submit' => 'Save',);
        } else {
            $newsid = Get::number(0);
            $news = DB::table('post')->where('pid=' . $newsid)->findOne();
            $news['submit'] = 'Update';
        }

        $d=DB::table('posttype')->findAll('cname,ptid');
        $postTypes=Html::select(arrayValueToKey($d),array(
            'id'=>'first',
            'name'=>'id_first',
            'data-live-search'=>'true',
            'class'=>'form-control',
            'border'=>'1px solid #ccc'
        ),$news['ptid']);

        $data = array(
            'news' => $news,
            'postTypes'=>$postTypes,
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

}
