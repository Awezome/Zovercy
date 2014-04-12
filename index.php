<?php

include './vendor/CloudPHP/App.php';

$app = new APP('app/home/controller','app/home/view');
$app->run();
