<?php

use app\mmadmin\core\Application;

$db = require __DIR__ . '/../../config/db.php';
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
        'session' =>[
            'name'=>'MMABESID'
        ],
        'db' => $db,
        'user' => [
            'identityClass' => '\app\backend\models\Admin',
            'enableAutoLogin' => true,
            'loginUrl' => [
                'login'
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
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
            'class' => '\app\mmadmin\core\CoreAssetManager'
        ],
        'urlManager' => [
            'class' => 'app\mmadmin\components\BackendUrlManager',
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => '\yii\i18n\DbMessageSource'
                ],
                'backend' => [
                    'class' => '\yii\i18n\DbMessageSource'
                ],
            ],
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['115.198.128.213','127.0.0.1', '::1'],
    ];
}

return $config;
