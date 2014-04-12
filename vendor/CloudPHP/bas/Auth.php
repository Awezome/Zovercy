<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author YunPeng
 */
class Auth {

    static function run() {
        $apps=self::findAction(Z::$app, 0);
        if (empty($apps)) {
            return false;
        }
        $controllers =self::findAction(Z::$controller, $apps['authid']);
        if (empty($controllers)) {
            return false;
        }
        $actions =self::findAction(Z::$action,$controllers['authid']); 
        if (empty($actions)) {
            return false;
        }
        
        $roleid = Z::$roleid;
        $roleauths = Z::$db->table('uroleauth')->where("roleid='$roleid' and authid=" . $actions['authid'])->findOne('id');
        if (empty($roleauths)) {
            //Func::errorMessage('No Auth');
            Func::jump(Z::$link.'index.php/login/');
        }
        return true;
    }
    
    static private function findAction($action,$parentid){
        return Z::$db->table('uauth')->where("action='$action' and parentid=$parentid")->findOne('authid');
    }

}
