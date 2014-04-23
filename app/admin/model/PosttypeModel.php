<?php

/**
 * Created by PhpStorm.
 * User: YunPeng
 * Date: 4/19/14
 * Time: 5:22 PM
 */
class PosttypeModel {
    function getPosttype(){
        return DB::table('posttype')->where('1 order by level,parentid,torder')->findAll();
    }

    function arrayLists(array &$arr) {
        $arrayFlag = array();
        $size = count($arr);
        for ($i = 0; $i < $size; $i++) {
            $value = $arr[$i];
            if ($value['level'] == 1) {
                $arrayFlag['i' . $value['ptid']] = $i;
            } else {
                unset($arr[$i]);
                $pos = $arrayFlag['i' . $value['parentid']] + 1;
                arrayInsert($arr, array($value), $pos);
                arrayInsert($arrayFlag, array('i' . $value['ptid'] => $pos), $pos);
                $k = 0;
                foreach ($arrayFlag as $key => $v) {
                    if ($k > $pos) {
                        $arrayFlag[$key] += 1;
                    }
                    $k++;
                }
            }
        }
    }

    function showPostSelect($results=null,$default=''){
        if($results==null){
            $results=$this->getPosttype();
        }
        return Html::selectArrayValue($results,'cname','ptid',array(
            'id'=>'first',
            'name'=>'id_first',
            'data-live-search'=>'true',
            'class'=>'form-control',
            'border'=>'1px solid #ccc'
        ),$default);
    }

    function selectRadio(array $data, $default = '') {
        $s='';
        foreach($data as $key=>$value){
        $s.= '<div class="m-b-10"><input type="radio" name="posttype" value="'.$value.'" class="icheck">'
             .'<span class="m-l-10">'.$key.'</span></div>';
        }
        return $s;
    }
}

