<?php
if(!defined('IN_HISUNPHP'))	exit('Access Denied');

class Str{
	public static function comsubstr($string,$length){
		$length1 = mb_strlen ($string,$charset);
		if($length>=$length1){
			return $string;
		}else{
			$string = mb_substr($string,0,$length-3,$charset);
			$string.='...';
			return $string;
		}
	}//在一个字符串中截取前$length个字符//$string：待截取的字符串,$length：需要截取的长度

	static function cleanText($string){
		return htmlspecialchars($string);
	}

	static function anticleanSql($string){
		return get_magic_quotes_gpc()?stripslashes($string):$string;
	}
	
	static function cleanSql($string) {
		if(is_array($string)) //如果转义的是数组则对数组中的value进行递归转义
			foreach($string as $key => $val)
				$string[$key] = self::cleanSql($val);
		else
			$string = addslashes($string); //进行转义
		return $string;
	}//对sql的一些字符进行转义 ,对单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符），进行转义

	static function cleanJs($js){
		return preg_replace("'<script[^>]*?>.*?</script>'si",'', $js);
	}
	
	static function cleanHtml($string) {
		if(is_array($string)) //如果转义的是数组则对数组中的value进行递归转义
			foreach($string as $key => $val)
				$string[$key] =self::cleanHtml($val);
		else
			$string = htmlspecialchars($string); //进行转义
		return $string;
	}//对$string中的html标签进行替换转义

	public static function strexists($haystack, $needle) {
		return !(strpos($haystack, $needle) === FALSE);
	}//判断字符串是否存在	//$haystack：	查找范围,$needle：		要查找的内容

	public static function NoRand($begin,$end,$limit=9){
		$rand_array=range($begin,$end);
		shuffle($rand_array);//调用现成的数组随机排列函数
		return array_slice($rand_array,0,$limit);//截取前$limit个
	}//产生不重复的数字

	static function random($length, $numeric = 0) {
		PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
		$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
		$hash = '';
		$max = strlen($seed) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $seed[mt_rand(0, $max)];
		}
		return $hash;
	}//产生随机字符//$length：要产生的随机字符串长度 $numeric：	是否为纯数字，当为0是表示非纯数字

}
?>
