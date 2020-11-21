<?php
require __DIR__ . '/../env.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ .'/../mmadmin/core/Application.php';
$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../config/common.php', 
    require __DIR__ . '/../backend/config/web.php');
(new \app\mmadmin\core\Application($config))->run();