<?php
return [
    'id' => 'base',
    'name' => getenv('APP_NAME'),
    'version' => 'beta',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'DuAdmin\Components\Bootstrap'
    ],
    'timeZone' => 'Asia/Shanghai',
    //'language' => 'zh-CN',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'validators' => [
        'slug' => '\DuAdmin\Validators\SlugValidator',
        'mobile' => '\DuAdmin\Validators\MobileValidator', //手机验证
        'alternative' => '\DuAdmin\Validators\AlternativeValidator', //二选一验证
    ],
    'components' => [
        'view' => [
            'class' => 'DuAdmin\Core\CoreView',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            'cache' => 'cache'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'formatter' => [
            'timeZone' => 'Asia/Shanghai',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'dateFormat' => 'yyyy-MM-dd',
            'timeFormat' => 'HH:mm:ss'
        ],
        'mailer' => [
            'class' => 'DuAdmin\Components\AppMailer'
        ]
    ]
];
