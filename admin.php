<?php

include './vendor/CloudPHP/App.php';

$app = new APP('app/admin/controller','admin/template/');
$app->run();