<?php
// 数据库配置放在具体的项目中是方便项目独立配置，项目之间相互隔离
$db = require __DIR__ . '/db.php';
$config = [
    'controllerNamespace' => 'app\api\controllers',
    'components' => [
        'db' => $db,
        'user' => [
            'identityClass' => '\DuAdmin\Models\User',
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
        'request' => [
            'enableCookieValidation'=>false,
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
            'as responseJson' => '\DuAdmin\Behaviors\ResponseJson'
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
