<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of posttype
 *
 * @author YunPeng
 */

class posttype extends Controller{
    function auto(){
        $ddd=$this->model->getPosttype();
        $data=array(
            'results' =>$ddd,
            'newDataSelect'=>$this->model->showPostSelect($ddd),
        );
        $this->setData($data);
        $this->loadView();
    }

    function save(){
        $name=Input::text('typename');
        $parentid=Input::number('posttype');

        DB::table('posttype')->save(array(
            'cname'=>$name,
            'parentid'=>$parentid,
            'level'=>$this->model->getLevel($parentid),
        ));

        Html::jump(URL::controller());
    }

    function edit(){
        $ddd=$this->model->getPosttype();
        $data=array(
            'newDataSelect'=>$this->model->showPostSelect($ddd),
        );
        $this->setData($data);
        $this->loadPage('posttypenew');
    }
}
