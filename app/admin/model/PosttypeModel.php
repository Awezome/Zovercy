<?php
/**
 * Created by PhpStorm.
 * User: YunPeng
 * Date: 4/19/14
 * Time: 5:22 PM
 */
class PosttypeModel{

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
}

