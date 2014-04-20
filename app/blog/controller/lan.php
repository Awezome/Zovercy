<?php

$_SESSION['lan'] = in_array($_GET['lan'], array('zh-cn', 'en-us')) ? $_GET['lan'] : 'zh-cn';


