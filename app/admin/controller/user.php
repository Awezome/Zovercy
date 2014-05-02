<?php

class user extends Controller {

    function auto() {
        $page = new Page('user', '*','userid');

        $data=array(
            'newpage' =>$page->run(),
            'results' => $page->sql()
        );
        $this->setData($data);
        $this->loadView('userlists');
    }

    function add(){
        $results=array(
            'username'=>'',
            'nickname'=>'',
            'email'=>'',
        );
        $this->setData(array(
            'results'=>$results,
        ));
        $this->loadView('useredit');
    }

    function edit() {
        $name=Get::string(0);
        $results=DB::table('user')->where('username=?',array($name))
            ->find('username,nickname,email,roleid');
        $this->setData(array(
            'results'=>$results,
        ));
        $this->loadView('useredit');
    }

    function save() {

    }

    function delete(){

    }

    function show(){}

}
