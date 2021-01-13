<?php

$config = [
    'controllerNamespace' => 'Api\Controllers',
    'components' => [
        'user' => [
            'identityClass' => '\Api\Models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/api/app.log',
                    'levels' => explode(',', getenv('LOG_LEVELS'))
                ]
            ]
        ],
        'request' => [
            'enableCookieValidation'=>false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'urlManager' => [
            'class' => '\yii\web\UrlManager',
            'enablePrettyUrl' => true,
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
}
return $config;
