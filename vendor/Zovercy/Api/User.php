<?php
/**
 * Created by PhpStorm.
 * User: YunPeng
 * Date: 6/2/14
 * Time: 7:40 PM
 */

class User {
    static public function IdToName($id){
        return DB::table('user')->where('userid=?',array($id))->GetOne('username');
    }

    function NameToId(){

    }
} 