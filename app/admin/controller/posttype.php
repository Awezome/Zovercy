<?php

function arrayInsert(&$array, $index, $position) {
  //  $pos   = array_search($position, array_keys($array))+1;
    $pos=$position;
    $start = array_slice($array, 0, $pos);
    $end = array_slice($array, $pos);
    $array=array_merge($start,$index,$end);
}


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

function arrayLists(array &$arr){
    $arrayFlag=array();
    $size=count($arr);
    for($i=0;$i<$size;$i++){
        $value=$arr[$i];
        if($value['level']==1){
            $arrayFlag['i'.$value['ptid']]=$i;
        }else{
            unset($arr[$i]);
            $pos=$arrayFlag['i'.$value['parentid']]+1;
            arrayInsert($arr,array($value),$pos);
            arrayInsert($arrayFlag,array('i'.$value['ptid']=>$pos),$pos);
            $k=0;
            foreach($arrayFlag as $key=>$v){
                if($k>$pos){
                    $arrayFlag[$key]+=1;
                }
                $k++;
            }
        }
    }
}


class posttype extends Controller{
    function auto(){
        $ddd=DB::table('posttype')->where('1 order by level,parentid,torder')->findAll();
        arrayLists($ddd);

        $data=array(
            'results' =>$ddd,
            'newDataSelect'=>arrayValueToKey($ddd,'cname','ptid'),
        );
        $this->setData($data);
        $this->loadView('posttype');
    }
}
