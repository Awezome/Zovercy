<?php
/*
 * Class Cookie
 *
 * update : 2012-02-18
 *----------------------------------------------------------------------*
 * @author : ZYP            @time : 2012-01-11
 *----------------------------------------------------------------------*
 * Notes :
 *
 * $c = new Cookie (l);
 * $c -> set_cookie ($name , $value);		// setcookie
 * $c -> get_cookie ($name);		// getcookie
 * $c -> del_all_cookie ();		// delete all cookie in the websites
 *----------------------------------------------------------------------*
 */

if(!defined('IN_HISUNPHP'))	exit('Access Denied');

class Cookie{
	private $C;
	private $config=array();

	function __construct(){
		$this->config=APP::$CONFIG['COOKIE'];
		include_once 'class_code.php';
		$this->C=new Code;
	}

	function set_cookie($name,$value){
		$name=$this->config['PRE'].$name;
		$value = $this->C->encode($value,$this->config['KEY']); //调用父类的方法
		setcookie($name, $value, time() + $this->config['TIME']);
	}

	function get_cookie($name){
		$name=$this->config['PRE'].$name;
		$name=isset($_COOKIE[$name])?$_COOKIE[$name]:'';
		return $this->C->decode($name,$this->config['KEY']);
	}

	function del_cookie($name){
		//$uid = $this->get_cookie('uid');
		//mysql_query("UPDATE hisunphp_user SET is_online = 0 WHERE uid = $uid ");
		$name=$this->config['PRE'].$name;
		setcookie($name,'',time()-3600);
	}

	function del_all_cookie(){
		$uid = $this->get_cookie('uid');
		mysql_query("UPDATE hisunphp_user SET is_online = 0 WHERE uid = $uid ");
		foreach ($_COOKIE as $name => $value)
			setcookie($name,false,time()-3600);
	}
}

?>
