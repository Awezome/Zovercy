<?php

if (!defined('IN_HISUNPHP')) {
    exit('Access Denied');
}
Permit(1, 3);
$op = isset($_GET['op']) ? $_GET['op'] : 'default';

$topsums = $this->db->table('tour')->where('1 order by date desc limit 11')->findAll('tid,title,date'); //所有的

if ($op == 'addmsn' && $uid != '') {
    $u = $_POST['u'];
    $tid = $_POST['tid'];
    $ftype = $_POST['ftype'];
    $message = $_POST['message'];
    if (empty($message)) {
        echo "<script>alert('请填写内容后发送！'); history.go(-1);</script>";
    }
    $datetime = time();
    $this->db->table('msn')->insert("(parentid,uid,fuid,fusername,ftype,message,tid,date) VALUES (0,'$u','$uid','$username','$ftype','$message','$tid','$datetime')");
    echo "<script>alert('发送成功'); history.go(-1);</script>";
}
?>