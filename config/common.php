<?php
$config = [
    'id' => 'baiyuan-start-kit',
    'name' => 'Yii2',
    'version' => 'beta',
    'basePath' => dirname(__DIR__),
    'viewPath' => dirname(__DIR__) . '/themes/default',
    'bootstrap' => [
        'log'
    ],
    'language' => 'zh-CN',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset'
    ],
    'modules'=>[
        'backend'=>'app\backend\BackendModule'
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'kdyagjkuduebfdglsgdls'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache'
        ],
        'user' => [
            'identityClass' => 'app\kit\models\User',
            'enableAutoLogin' => true
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning'
                    ]
                ]
            ]
        ],
        'authManager' => [
            'class' => 'app\kit\core\CoreAuthManager',
            // uncomment if you want to cache RBAC items hierarchy
            'cache' => 'cache'
        ],

        'formatter' => [
            'timeZone' => 'Asia/Shanghai',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'dateFormat' => 'yyyy-MM-dd',
            'timeFormat' => 'HH:mm:ss'
        ],
        'mailer' => [
            'class' => 'app\kit\components\AppMailer'
        ]
    ]
];

return $config;
