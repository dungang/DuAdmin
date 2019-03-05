<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
// require __DIR__ . '/../third/aliyun-log-sdk/Log_Autoload.php';
// require __DIR__ . '/../third/aliyun-openapi-php-sdk/aliyun-php-sdk-core/Config.php';

$config = yii\helpers\ArrayHelper::merge(require __DIR__ . '/../config/common.php', require __DIR__ . '/../config/web.php');
(new yii\web\Application($config))->run();
