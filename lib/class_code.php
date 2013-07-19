<?php
/**
 * Class Code
 *
 * update : 2013-05-29
 *----------------------------------------------------------------------*
 * @improve : ZYP            @time : 2012-01-11
 *----------------------------------------------------------------------*
 * Notes :
 *
 * $c = new Code ();
 * $c -> encode($string_you_want_to_encode , $key_you_will_decode);		    // encode
 * $c -> decode($string_you_want_to_decode , $key_you_have_encoded);		//  decode
 *----------------------------------------------------------------------*
 */

class Code{
	public function encode($string,$key='zyp'){
		$encrypt_key = md5(rand(0,320000000));
		$encrypt_key_length=32;
		$ctr=0;
		$tmp = "";
		$string_l=strlen($string);
		for ($i=0;$i<$string_l;$i++){
			if ($ctr==$encrypt_key_length) $ctr=0;
			$code=substr($encrypt_key,$ctr,1);
			$tmp.= $code .(substr($string,$i,1) ^ $code);
			$ctr++;
		}
		return base64_encode($this->Keycode($tmp,$key));
	}

	public function decode($string,$key='zyp'){
		$string=base64_decode($string);
		$string = $this->keycode($string,$key);
		$tmp = "";

		$string_l=strlen($string);
		for ($i=0;$i<$string_l;$i+=2){
			$code = substr($string,$i,1);
			$codeplus= substr($string,$i+1,1);
			$tmp.= ($codeplus ^ $code);
		}
		return $tmp;
	}
	private function keycode($string,$encrypt_key){
		$encrypt_key = md5($encrypt_key);
		$ctr=0;
		$tmp ="";
		$string_l=strlen($string);
		$encrypt_key_length=32;
		for ($i=0;$i<$string_l;$i++){
			if ($ctr==$encrypt_key_length) $ctr=0;
			$tmp.= substr($string,$i,1) ^ substr($encrypt_key,$ctr,1);
			$ctr++;
		}
		return $tmp;
	}
}
?>
