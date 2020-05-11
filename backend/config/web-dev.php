<?php

use app\kit\core\Application;

// 数据库配置放在具体的项目中是方便项目独立配置，项目之间相互隔离
$db = require __DIR__ . '/../../config/db-dev.php';
$config = [
    //'basePath' => dirname(__DIR__),
    'mode' => Application::MODE_BACKEND,
    'controllerNamespace' => 'app\backend\controllers',
    'viewPath' => '@app/backend/views',
    'defaultRoute' => 'default',
    'modules'=>[
        'task'=>'app\backend\task\TaskModule',
    ],
    'components' => [
        'db' => $db,
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/backend/app.log',
                    'levels' => [
                        'error',
                        'warning'
                    ]
                ]
            ]
        ],
        'assetManager' => [
            'class' => 'app\kit\core\CoreAssetManager',
            'basePath' => '@app/public/assets'
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => '\yii\i18n\PhpMessageSource',
                    'basePath' => '@app/backend/messages',
                ],
            ],
        ],
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module'
        // 'panels'=>['log' => ['class' => 'yii\debug\panels\LogPanel']],
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'app\generators\Module',
        'generators' => [
            'crud' => [
                'class' => 'app\generators\crud\Generator'
            ],
            'model' => [
                'class' => 'app\generators\model\Generator',
                'baseClass' => 'app\kit\core\BaseModel',
                'ns' => 'app\kit\models',
                'queryNs' => 'app\kit\models'
            ],
            'addons' => [
                'class' => 'app\generators\addons\Generator'
            ]
        ]
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
