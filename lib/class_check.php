<?php
if(!defined('IN_HISUNPHP'))	exit('Access Denied'); 

class Check{
	public static function  mail($email) {
		return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
	}
}
?>