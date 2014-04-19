<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Html
 *
 * @author YunPeng
 */
class Html {
    public static function js($src){
        return '<script charset="utf-8" src="' .  URL::web() . $src . '" type="text/javascript"></script>';
    }
    
    public static function css($src){
        return '<link rel="stylesheet" href="' .  URL::web() . $src . ' " />';
    }
    
    public static function alert($str){
         echo "<script type='text/javascript'> alert('$str');</script>";
    }
    
    public static function jump($str){
        echo "<script type='text/javascript'>location.href='$str';</script>";
    }
    
    public static function jumpBack(){
        echo "<script type='text/javascript'>window.history.go(-1);</script>";
    }

    public static function select(array $data,array $option=array(),$default='') {
        $o='';
        foreach($option as $key=>$value){
            $o.=$key.'="'.$value.'" ';
        }
        $s='<select '.$o.'>';
       // $s.='<option value="0">------</option>';
        foreach ($data as $key=>$value) {
            $s.= '<option value="' .$value.'"';
            if ($value == $default)
                $s.= ' selected="selected"';
            $s.= '>' . $key . '</option>';
        }
        $s.= '</select>';
        return $s;
    }
}
