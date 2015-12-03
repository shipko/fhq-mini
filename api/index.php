<?php
// Debug?
define('YII_DEBUG',false);

header('Access-Control-Allow-Origin: *');
$dir = dirname(__FILE__);
$yii = $dir.'/vendor/yiisoft/yii/framework/yii.php';
$config = $dir.'/protected/config/main.php';


// include Yii bootstrap file
require_once($yii);

// create a Web application instance and run
Yii::createWebApplication($config)->run();
