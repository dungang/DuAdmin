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
            'enableAutoLogin'=>false,
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
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => 'json',
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
            'as responseJson' => '\app\mmadmin\behaviors\ResponseJson'
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
return $config;
