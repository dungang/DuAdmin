<?php

use app\mmadmin\core\Application;

$db = require __DIR__ . '/../../config/db-dev.php';
$config = [
    'mode' => Application::MODE_API,
    'controllerNamespace' => 'app\api\controllers',
    'components' => [
        'db' => $db,
        'user' => [
            'identityClass' => '\app\mmadmin\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/api/app.log',
                    'levels' => [
                        'error',
                        'warning'
                    ]
                ]
            ]
        ],
        'urlManager' => [
            'class' => '\yii\web\UrlManager',
            'enablePrettyUrl' => true,
            // 'enableStrictParsing' => true,
            // 'showScriptName' => true,
            // 'rules' => [
            //     ['class' => 'yii\rest\UrlRule', 'controller' => 'mmh/drug'],
            // ],
        ]
    ]
];

// configuration adjustments for 'dev' environment
$config['bootstrap'][] = 'debug';
$config['modules']['debug'] = [
    'class' => 'yii\debug\Module'
    // uncomment the following to add your IP if you are not connecting from localhost.
    // 'allowedIPs' => ['127.0.0.1', '::1'],
];
return $config;
