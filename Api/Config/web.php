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
