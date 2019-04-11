<?php

require_once __DIR__ . '/vendor/autoload.php';

$app =new \Zovercy\Zovercy(
    realpath(__DIR__)
);
$app->run();
