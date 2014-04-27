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
        $this->edit();
    }

    function edit() {

    }

    function save() {

    }

    function delete(){

    }

    function show(){}

}
