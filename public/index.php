<?php
define('RUNTIME_MODE', 'Frontend');
require __DIR__ . '/../env.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ .'/../DuAdmin/Core/Application.php';
$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../Config/common.php', 
    require __DIR__ . '/../frontend/Config/web.php');
(new \DuAdmin\Core\Application($config))->run();
