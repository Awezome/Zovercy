<?php

function _int($num) {
    return isset($num) ? intval($num) : 0;
}

function _empty($data) {
    if (!$data)
        Jump(THIS_HOST);
}

function GetRobot() {
    if (!defined('IS_ROBOT')) {
        $kw_spiders = 'Bot|Crawl|Spider|slurp|sohu-search|lycos|robozilla';
        $kw_browsers = 'MSIE|Netscape|Opera|Konqueror|Mozilla';
        if (!Str::strexists($_SERVER['HTTP_USER_AGENT'], 'http://') && preg_match("/($kw_browsers)/i", $_SERVER['HTTP_USER_AGENT'])) {
            define('IS_ROBOT', FALSE);
        } elseif (preg_match("/($kw_spiders)/i", $_SERVER['HTTP_USER_AGENT'])) {
            define('IS_ROBOT', TRUE);
        } else {
            define('IS_ROBOT', FALSE);
        }
    }
    if (defined('NOROBOT') && IS_ROBOT)
        exit(header("HTTP/1.1 403 Forbidden"));
}

//检查是否为蜘蛛程序，定义常量IS_ROBOT

function Jump($url) {
    header("Location: " . $url);
}

function a($out) {
    header('Content-Type:text/html;charset=utf-8');
    echo "<pre>";
    print_r($out);
    echo "</pre>";
    exit;
}

function p($out) {
    header('Content-Type:text/html;charset=utf-8');
    echo "<pre>";
    print_r($out);
    echo "</pre>";
}

function br() {
    echo '<br />';
}

function Permit($mingid, $maxgid, $word = "无权限操作，请先登录！") {
    global $gid;
    if (!( $mingid <= $gid && $gid <= $maxgid )) {
        echo "<script type='text/javascript'> alert('" . $word . "');location.href='" . THIS_HOST . "page/login';</script>";
        exit();
    }
}

function PermitLimt($mingid, $maxgid) {
    global $gid;
    if ($mingid <= $gid && $gid <= $maxgid)
        return true;
    else
        return false;
}

//获取客户端IP
function GetIP() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "unknown";
    return($ip);
}

function Debug() {
    if (DEBUG_MODE) {
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);
    } else {
        error_reporting(0);
    }
}

//错误报告

function ErrorDiv($string) {
    echo "<div align=\"center\" style=\"width:100%;\"><div style=\"text-align:left;margin-top:40px;padding:10px;width:800px;line-height:1.5;border:1px solid #D52C2B;background:#FFEBE8\">";
    echo $string;
    echo "</div></div>";
    exit();
}

function formSelect($table, $id, $name, $getid = 0, $where = 0) {
    $link = new db;
    if (!$where)
        $where = "parentid=0";
    $selects = $link->table($table)->where($where)->selectall();
    echo "<select id='select' name='" . $id . "'>";
    echo "<option value='0'>请选择分类</option>";
    foreach ($selects as $select) {
        echo "<option value=" . $select[$id];
        if ($select[$id] == $getid)
            echo " selected='selected'";
        echo ">" . $select['cname'] . "</option>";
    }
    echo "</select>";
}

function formTourSelect($getid = 0, $where = 0) {
    $link = new db;
    if (!$where)
        $where = "parentid=0";
    $selects = $link->table('tourtype')->where("$where")->selectall();
    echo "<select id='select' name='ntid'>";
    echo "<option value='0'>请选择分类</option>";
    foreach ($selects as $select) {
        echo "<option value=" . $select['ttid'];
        if ($select['ttid'] == $getid)
            echo " selected='selected'";
        echo ">" . $select['cname'] . "</option>";
    }
    echo "</select>";
}

function newstype_newlist($a) {
    $b = array();
    $count = count($a);
    for ($i = 0, $p = 0; $i < $count; $i++) {
        if ($a[$i]['parentid'] == 0) {
            $b[++$p] = $a[$i];
            $temp = $b[$p]['ntid'];
            for ($j = 0; $j < $count; $j++)
                if ($temp == $a[$j]['parentid'])
                    $b[++$p] = $a[$j];
        }
    }
    return $b;
}

function is_online($uid) {
    $link = new db;
    $user = $link->table('user')->where('uid=' . $uid)->selectone('last_logtime');
    $time_ok = time() - $user['last_logtime'] < 1800 ? 1 : 0;
    if ($time_ok)
        return true;
    else
        return false;
}

function imageWaterMark($groundImage, $waterImage = '', $waterPos = 9, $alpha = 50) {
    //读取水印文件
    if (!empty($waterImage) && file_exists($waterImage)) {
        $water_info = getimagesize($waterImage);
        $water_w = $water_info[0]; //取得水印图片的宽
        $water_h = $water_info[1]; //取得水印图片的高 

        switch ($water_info[2]) {//取得水印图片的格式{
            case 1:$water_im = imagecreatefromgif($waterImage);
                break;
            case 2:$water_im = imagecreatefromjpeg($waterImage);
                break;
            case 3:$water_im = imagecreatefrompng($waterImage);
                break;
            default:die('暂不支持该文件格式，请用图片处理软件将图片转换为GIF、JPG、PNG格式。');
        }
    }

    //读取背景图片
    if (!empty($groundImage) && file_exists($groundImage)) {
        $ground_info = getimagesize($groundImage);
        $ground_w = $ground_info[0]; //取得背景图片的宽
        $ground_h = $ground_info[1]; //取得背景图片的高 

        switch ($ground_info[2]) {//取得背景图片的格式
            case 1:$ground_im = imagecreatefromgif($groundImage);
                break;
            case 2:$ground_im = imagecreatefromjpeg($groundImage);
                break;
            case 3:$ground_im = imagecreatefrompng($groundImage);
                break;
            default:die($formatMsg);
        }
    } else {
        die("需要加水印的图片不存在！");
    }

    //水印位置

    $w = $water_w;
    $h = $water_h;
    $label = "图片的";

    if (($ground_w < $w) || ($ground_h < $h)) {
        echo "需要加水印的图片的长度或宽度比水印" . $label . "还小，无法生成水印！";
        return;
    }
    switch ($waterPos) {
        case 0://随机
            $posX = rand(0, ($ground_w - $w));
            $posY = rand(0, ($ground_h - $h));
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
            if (!$isWaterImage) {
                $posY = $ground_h - $h - 20;
            }
            break;
        default://随机
            $posX = rand(0, ($ground_w - $w));
            $posY = rand(0, ($ground_h - $h));
            break;
    }

    //设定图像的混色模式
    imagealphablending($ground_im, true);


    //imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//拷贝水印到目标文件
    //生成混合图像
    imagecopymerge($ground_im, $water_im, $posX, $posY, 0, 0, $water_w, $water_h, $alpha);

    //生成水印后的图片
    @unlink($groundImage);
    switch ($ground_info[2]) {//取得背景图片的格式
        case 1:imagegif($ground_im, $groundImage);
            break;
        case 2:imagejpeg($ground_im, $groundImage, 100);
            break;
        case 3:imagepng($ground_im, $groundImage);
            break;
        default:die($errorMsg);
    }
    //释放内存
    if (isset($water_info))
        unset($water_info);
    if (isset($water_im))
        imagedestroy($water_im);
    unset($ground_info);
    imagedestroy($ground_im);
}

function Weather($city = '') {
    //$str="(function(){var w=[];w['青岛']=[{s1:'晴',s2:'晴',f1:'qing',f2:'qing',t1:'15',t2:'10',p1:'3-4',p2:'4-5',d1:'西南风',d2:'南风'}];var add={now:'2012-11-01 15:38:44',time:'1351755524',update:'北京时间11月01日08:00更新',error:'0',total:'1'};window.SWther={w:w,add:add};})();//0";
    $str = file_get_contents('http://php.weather.sina.com.cn/iframe/index/w_cl.php?code=js&city=' . $city);
    $str = iconv("GB2312", "UTF-8", $str);
    preg_match_all("|(.*)['](.*)['](.*)|isU", $str, $str_ary);
    return $str_ary[2];
}

?>
