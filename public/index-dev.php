<?php

// NOTE: Make sure this file is not accessible when deployed to production
if (! in_array(@$_SERVER['REMOTE_ADDR'], [
    '127.0.0.1',
    '::1'
])) {
    die('You are not allowed to access this file.');
}
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'dev');

//global $classLoader;
$classLoader = require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ .'/../mmadmin/core/Application.php';
$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../config/common.php', 
    require __DIR__ . '/../frontend/config/web-dev.php');
(new \app\mmadmin\core\Application($config))->run();
