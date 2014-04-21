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
   // private $model='posttype';

    function auto(){
        $ddd=DB::table('posttype')->where('1 order by level,parentid,torder')->findAll();
        $this->model->arrayLists($ddd);

        $data=array(
            'results' =>$ddd,
            'newDataSelect'=>arrayValueToKey($ddd,'cname','ptid'),
        );
        $this->setData($data);
        $this->loadView('posttype');
    }
}
