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
}
