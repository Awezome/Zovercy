<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Z
 *
 * @author YunPeng
 */
class Z {

    static $userid=0;
    static $username='';
    static $roleid=0;
    
    static $config;
    
    static $db = null;
    
    static $link;
    static $theme;

    static $app;
    static $controller;
    static $action;
    static $get = array();
    static $model;
    
    static $online=false;
    
    static $themedir='';
    static $sourcedir='';
    
    static $redison=false;
    static $redis=null;

    public static function link($app=''){
        if($app==''){
            $app=Z::$app;
        }
        echo Base::getLink().'public/'.$app.'/';
    }
}
