<?php
define('RUNTIME_MODE', 'Api');
require __DIR__ . '/../DuAdmin/env.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ .'/../DuAdmin/Core/Application.php';
$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../Config/common.php',
    require __DIR__ . '/../DuAdmin/config.php', 
    require __DIR__ . '/../Api/Config/web.php');
(new \DuAdmin\Core\Application($config))->run();