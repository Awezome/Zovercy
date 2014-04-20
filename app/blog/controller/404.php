<?php

$string = '404<br />';
$string.= '您访问的网页不存在！<br />';
$string.="<a href='" . THIS_HOST . "'>返回首页</a>";
ErrorDiv($string);
