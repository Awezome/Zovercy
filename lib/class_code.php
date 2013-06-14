<?php
/*
 * Class Code
 *
 * update : 2012-01-11
 *----------------------------------------------------------------------*
 * @improve : ZYP            @time : 2012-01-11
 *----------------------------------------------------------------------*
 * Notes :
 *
 * $c = new Code ();
 * $c -> encode($string_you_want_to_encode , $key_you_will_decode);		// encode
 * $c -> decode($string_you_want_to_decode , $key_you_have_encoded);		//  decode
 *----------------------------------------------------------------------*
 */
if(!defined('IN_HISUNPHP'))	exit('Access Denied');

class Code{
	public function encode($string,$key='hisunphp'){
		$encrypt_key = md5(rand(0,320000000));
		$ctr=0;
		$tmp = "";
		for ($i=0;$i<strlen($string);$i++){
			if ($ctr==strlen($encrypt_key)) $ctr=0;
				$tmp.= substr($encrypt_key,$ctr,1) .
			(substr($string,$i,1) ^ substr($encrypt_key,$ctr,1));
			$ctr++;
		}
		return base64_encode($this->Keycode($tmp,$key));
	}

	public function decode($string,$key='hisunphp'){
		$string=base64_decode($string);
		$string = $this->keycode($string,$key);
		$tmp = "";
		for ($i=0;$i<strlen($string);$i++){
			$md5 = substr($string,$i,1);
			$i++;
			$tmp.= (substr($string,$i,1) ^ $md5);
		}
		return $tmp;
	}
	private function keycode($string,$encrypt_key){
		$encrypt_key = md5($encrypt_key);
		$ctr=0;
		$tmp ="";

		for ($i=0;$i<strlen($string);$i++){
			if ($ctr==strlen($encrypt_key)) $ctr=0;
			$tmp.= substr($string,$i,1) ^ substr($encrypt_key,$ctr,1);
			$ctr++;
		}
	return $tmp;
	}

	public static function encrypt($string){
		$short = substr($string,0,4);
		$string = md5(md5($string).$short);
		return $string;
	}
}

?>
