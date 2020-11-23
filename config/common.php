<?php
return [
    'id' => 'base',
    'name' => 'MMAdmin',
    'version' => 'beta',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'app\mmadmin\components\Bootstrap'
    ],
    'timeZone' => 'Asia/Shanghai',
    //'language' => 'zh-CN',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset'
    ],
    'validators' => [
        'slug' => '\app\mmadmin\validators\SlugValidator',
        'mobile' => '\app\mmadmin\validators\MobileValidator', //手机验证
        'alternative' => '\app\mmadmin\validators\AlternativeValidator', //二选一验证
    ],
    'modules' => [
        'marketing-sms'=> '\Addons\MarketingSms\Addon',
        'theme'=> '\Addons\Theme\Addon',
    ],
    'components' => [
        'view' => [
            'class' => 'app\mmadmin\core\CoreView',
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
            'class' => 'app\mmadmin\components\AppMailer'
        ]
    ]
];
