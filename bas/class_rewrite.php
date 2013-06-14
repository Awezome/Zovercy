<?php
/*
 * Class Rewrite
 *
 * update : 2012-01-24
 *----------------------------------------------------------------------*
 * @author : ZYP            @time : 2012-01-24
 *----------------------------------------------------------------------*
 * Notes :
 *
 *----------------------------------------------------------------------*
 */
if(!defined('IN_HISUNPHP'))	exit('Access Denied');
class rewrite{
	static function run(){
		$name=str_replace($_SERVER["SCRIPT_NAME"],"",$_SERVER["REQUEST_URI"]);
		//$navs=substr($name,1,-5);
		$url = explode("/",$name);
		return $url;
	}

}
?>
