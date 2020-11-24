<?php

use app\mmadmin\core\Application;

$db = require __DIR__ . '/../../config/db.php';
$config = [
    //'basePath' => dirname(__DIR__),
    'mode' => Application::MODE_BACKEND,
    'controllerNamespace' => 'app\backend\controllers',
    'viewPath' => '@app/backend/views',
    'defaultRoute' => 'default',
    'components' => [
        'request' => [
            'cookieValidationKey' => getenv('APP_KEY'),
            'enableCsrfCookie' => false
        ],
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
        'urlManager' => [
            'class' => 'app\mmadmin\components\BackendUrlManager',
        ],
        'assetManager' => [
            'class' => 'app\mmadmin\core\CoreAssetManager',
            'basePath' => '@app/public/assets'
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
                'baseClass' => 'app\mmadmin\core\BaseModel',
                'ns' => 'app\mmadmin\models',
                'queryNs' => 'app\mmadmin\models'
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
