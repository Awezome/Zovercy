<?php
/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/3/14
 * Time: 3:10 PM
 */

include 'Bootstrap.php';

//init
DB::init($dbConfig);

//connect
DB::connect('pdotest');
//DB::connect('leanlv');

//show log , must after init & connect
DB::log(true);

//find one
//$one=DB::table('user')->where('name=?',array('lulu'))->find();

//find all
p(DB::table('user')->findAll(array('name')));

//delete
//DB::table('user')->save(array('name'=>'mike','time'=>time()));

//DB::table('user')->where('id=?',array(11))->delete();

//update
//DB::table('user')->where('id=?',array(11))->update(array('id'=>11,'name'=>'like'));

//query
//DB::query('select * from user where id=?',array('2'));

//transaction
DB::transaction(function(){
    DB::table('user')->save(array('name'=>'haha','time'=>date('Y-m-d H:i:s',time())));
    DB::table('user')->save(array('id'=>1,'name'=>'mike','time'=>time()));
});

//pdo DB::pdo() <==> new PDO();
//$pdo=DB::pdo();
//$pdo->query();

//还有点问题
//DB::disconnect('pdotest');