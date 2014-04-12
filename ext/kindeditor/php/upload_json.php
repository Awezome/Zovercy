<?php
$is_water=isset($_GET['water'])?intval($_GET['water']):0;

function imageWaterMark($groundImage, $waterPos=0, $waterImage='', $alpha=100){
	//读取水印文件
	if(!empty($waterImage) && file_exists($waterImage)){
		$water_info   = getimagesize($waterImage);
		$water_w   = $water_info[0];//取得水印图片的宽
		$water_h   = $water_info[1];//取得水印图片的高 
		
		switch($water_info[2]){//取得水印图片的格式{
			case 1:$water_im = imagecreatefromgif($waterImage);break;
			case 2:$water_im = imagecreatefromjpeg($waterImage);break;
			case 3:$water_im = imagecreatefrompng($waterImage);break;
			default:die('暂不支持该文件格式，请用图片处理软件将图片转换为GIF、JPG、PNG格式。');
		}
	} 
	
	//读取背景图片
	if(!empty($groundImage) && file_exists($groundImage)){
		$ground_info = getimagesize($groundImage);
		$ground_w   = $ground_info[0];//取得背景图片的宽
		$ground_h   = $ground_info[1];//取得背景图片的高 
		
		switch($ground_info[2]){//取得背景图片的格式
			case 1:$ground_im = imagecreatefromgif($groundImage);break;
			case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
			case 3:$ground_im = imagecreatefrompng($groundImage);break;
			default:die($formatMsg);
		}
	}else{
		die("需要加水印的图片不存在！");
	} 
	
	//水印位置
	
	$w = $water_w;
	$h = $water_h;
	$label = "图片的";
	
	if(($ground_w<$w) || ($ground_h<$h)){
		echo "需要加水印的图片的长度或宽度比水印".$label."还小，无法生成水印！";
		return;
	}
	switch($waterPos){
		case 0://随机
			$posX = rand(0,($ground_w - $w));
			$posY = rand(0,($ground_h - $h));
			break;
		case 1://1为顶端居左
			$posX = 0;
			$posY = 0;
			break;
		case 2://2为顶端居中
			$posX = ($ground_w - $w) / 2;
			$posY = 0;
			break;
		case 3://3为顶端居右
			$posX = $ground_w - $w;
			$posY = 0;
			break;
		case 4://4为中部居左
			$posX = 0;
			$posY = ($ground_h - $h) / 2;
			break;
		case 5://5为中部居中
			$posX = ($ground_w - $w) / 2;
			$posY = ($ground_h - $h) / 2;
			break;
		case 6://6为中部居右
			$posX = $ground_w - $w;
			$posY = ($ground_h - $h) / 2;
			break;
		case 7://7为底端居左
			$posX = 0;
			$posY = $ground_h - $h;
			break;
		case 8://8为底端居中
			$posX = ($ground_w - $w) / 2;
			$posY = $ground_h - $h;
			break;
		case 9://9为底端居右
			$posX = $ground_w - $w;
			$posY = $ground_h - $h;
			if(!$isWaterImage){
				$posY = $ground_h - $h-20;
			}
			break;
		default://随机
			$posX = rand(0,($ground_w - $w));
			$posY = rand(0,($ground_h - $h));
			break;
	} 
	
	//设定图像的混色模式
	imagealphablending($ground_im, true); 
	
	
	//imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//拷贝水印到目标文件
	//生成混合图像
	imagecopymerge($ground_im, $water_im, $posX, $posY, 0, 0, $water_w, $water_h, $alpha);	
	
	//生成水印后的图片
	@unlink($groundImage);
	switch($ground_info[2]){//取得背景图片的格式
		case 1:imagegif($ground_im,$groundImage);break;
		case 2:imagejpeg($ground_im,$groundImage);break;
		case 3:imagepng($ground_im,$groundImage);break;
		default:die($errorMsg);
	} 
	//释放内存
	if(isset($water_info)) unset($water_info);
	if(isset($water_im)) imagedestroy($water_im);
	unset($ground_info);
	imagedestroy($ground_im);
}

 /***********************************
 * KindEditor PHP
 * 
 * 本PHP程序是演示程序，建议不要直接在实际项目中使用。
 * 如果您确定直接使用本程序，使用之前请仔细确认相关安全设置。
 * 
 */

require_once 'JSON.php';

//文件保存目录路径
$save_path = $kind_path;
//文件保存目录URL
$save_url = $kind_url;
//定义允许上传的文件扩展名
$ext_arr = array(
	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
	'flash' => array('swf', 'flv'),
	'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);
//最大文件大小
$max_size = 10000000000000;
$save_path = realpath($save_path) . '/';

//PHP上传失败
if (!empty($_FILES['imgFile']['error'])) {
	switch($_FILES['imgFile']['error']){
		case '1':
			$error = '上传图片超过限制大小,请压缩后再上传。';
			break;
		case '2':
			$error = '超过表单允许的大小。';
			break;
		case '3':
			$error = '图片只有部分被上传。';
			break;
		case '4':
			$error = '请选择图片。';
			break;
		case '6':
			$error = '找不到临时目录。';
			break;
		case '7':
			$error = '写文件到硬盘出错。';
			break;
		case '8':
			$error = 'File upload stopped by extension。';
			break;
		case '999':
		default:
			$error = '未知错误。';
	}
	alert($error);
}

//有上传文件时
if (empty($_FILES) === false) {
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("请选择文件。");
	}
	//检查目录
	if (@is_dir($save_path) === false) {
		alert("上传目录不存在。");
	}
	//检查目录写权限
	if (@is_writable($save_path) === false) {
		alert("上传目录没有写权限。");
	}
	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("上传失败。");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		alert("上传文件大小超过限制。");
	}
	//检查目录名
	$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
	if (empty($ext_arr[$dir_name])) {
		alert("目录名不正确。");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//检查扩展名
	if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
		alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
	}
	//创建文件夹
	if ($dir_name !== '') {
		$save_path .= $dir_name . "/";
		$save_url .= $dir_name . "/";
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
	}
	$ymd = date("Ymd");
	$save_path .= $ymd . "/";
	$save_url .= $ymd . "/";
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}
	//新文件名
	$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
	//移动文件
	$file_path = $save_path . $new_file_name;
	if (move_uploaded_file($tmp_name, $file_path) === false){
		alert("上传文件失败。");
	}
	@chmod($file_path, 0644);
	$file_url = $save_url . $new_file_name;
	

//========for thumbimg========
	$thum_water_info=getimagesize($file_path);
	$thum_water_w=$thum_water_info[0];//取得水印图片的宽
	$thum_water_h=$thum_water_info[1];//取得水印图片的宽
	echo $thum_water_w;

	if($thum_water_w>610){
		$thum_water_h=610*$thum_water_h/$thum_water_w;
		define('IN_HISUNPHP', true);
		include dirname(dirname(dirname(dirname(__FILE__)))).'/lib/Thumb.php';

		$now_dir=dirname($file_path);
		$cut_img=new Thumb('',$now_dir);
		$cut_img->reImg($file_path,610,$thum_water_h);
	}
//========thumb end========	
//========for watermark========
	if($is_water==1)
		imageWaterMark($file_path, 9, 'water.gif', 50);
//========watermark end========

	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 0, 'url' => $file_url));
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}
?>