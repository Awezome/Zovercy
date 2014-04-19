<?php
/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/14/14
 * Time: 2:36 PM
 */


function p($o,$title=''){
    echo '<pre style="background:#ddd;font-weight: 700;font-size: 14px">';
    echo '<span style="color:red">'.$title.'</span><br />';
    print_r($o);
    echo '</pre>';
}

function arrayValueToKey($a){
    $ds=array();
    $kk=$kk=array_keys($a[0]);
    foreach($a as $value){
        $ds[$value[$kk[0]]]=$value[$kk[1]];
    }
    return $ds;
}