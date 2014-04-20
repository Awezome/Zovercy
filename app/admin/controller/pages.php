<?php

class pages extends Controller {

    function lists() {
        $page = new Page('page', 'pageid,name,title,addtime','addtime'); 

        $data=array(
            'newpage' =>$page->run(),
            'results' => $page->sql()
        );        
        $this->setData($data);
        $this->loadView('pageslists');
    }

    function edit() {
        if (Get::number()==null) {
            $news = array('name'=>'','title' => '', 'text' => '', 'addtime' => date('Y-m-d h:i:s'),'submit' => 'Save');
        } else {
            $newsid = Get::number(0);
            $news = DB::table('page')->where('pageid=' . $newsid)->findOne();
            $news['submit'] = 'Update';
        }

        $data = array(
            'news' => $news
        );
        $this->setData($data);      
        $this->loadView('pagesedit');
    }

    function save() {
        $pid=Input::number('pid');

        $set = array(
            'title' =>Input::text('title'),
            'text' =>Input::get('postedit'),
            'name'=>Input::text('name'),
            'addtime' =>Input::get('this_time'),
        );
        
        if($pid){
            DB::table('page')->where("pageid=" . $pid)->update($set);
            Html::alert('编辑成功');
        }else{
            DB::table('page')->save($set);
            $pid=DB::saveId();
            Html::alert('添加成功');
        }

        Html::jump( URL::controller() . 'edit/' . $pid . '/');
    }
    
    function delete(){
        $pid =Get::number(0);
        DB::table('page')->where('pageid='.$pid)->delete();
        Html::jump( URL::controller() . 'lists/');
    }

}
