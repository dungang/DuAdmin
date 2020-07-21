<?php
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

$classLoader = require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ .'/../mmadmin/core/Application.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../config/common.php', 
    require __DIR__ . '/../backend/config/web.php');
(new \app\mmadmin\core\Application($config))->run();