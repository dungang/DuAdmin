<?php
// 数据库配置放在具体的项目中是方便项目独立配置，项目之间相互隔离
$db = require __DIR__ . '/../../config/db.php';
$config = [
    //'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'Backend\Controllers',
    'viewPath' => '@app/backend/views',
    'defaultRoute' => 'default',
    'components' => [
        'request' => [
            'cookieValidationKey' => getenv('APP_KEY'),
            'enableCsrfCookie' => false
        ],
        'session' =>[
            'name'=>'DJPBSID'
        ],
        'db' => $db,
        'user' => [
            'identityClass' => '\Backend\Models\Admin',
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
            'class' => 'DuAdmin\Components\BackendUrlManager',
        ],
        'assetManager' => [
            'class' => 'DuAdmin\Core\CoreAssetManager',
            'basePath' => '@app/public/assets'
        ],
        'i18n' => [
            'translations' => [
                'backend' => [
                    'class' => '\yii\i18n\PhpMessageSource'
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
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
