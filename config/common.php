<?php
$config = [
    'id' => 'base',
    'name' => 'BY-CMS',
    'version' => 'beta',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'app\kit\components\Bootstrap'
    ],
    'timeZone'=>'Asia/Shanghai',
    'language' => 'zh-CN',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset'
    ],
    'modules' => [
        'backend' => 'app\backend\BackendModule'
    ],
    'components' => [
        'view' => [
            'class'=>'app\kit\core\CoreView',
        ],
        'request' => [
            'cookieValidationKey' => 'kdyagjkuduebfdglsgdls'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache'
        ],
        'user' => [
            'identityClass' => 'app\kit\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => [
                'backend/login'
            ]
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
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            'cache' => 'cache'
        ],
        'urlManager' => [
            'class' => 'app\kit\components\RewriteUrl',
            //'cache' => 'cache',
            //'suffix' => '.html',
            'enablePrettyUrl' => true,
            'rules' => [
                '<slug:[\w \-]+>' => 'site/page/'
            ]
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
