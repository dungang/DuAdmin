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
    'timeZone' => 'Asia/Shanghai',
    'language' => 'zh-CN',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset'
    ],
    'validators' => [
        'mobile' => '\app\kit\validators\MobileValidator', //手机验证
        'alternative' => '\app\kit\validators\AlternativeValidator', //二选一验证
    ],
    'modules' => [
        'theme' => 'app\addons\theme\Addon',
        'flash' => 'app\addons\flash\Addon',
        'cms' => '\app\addons\cms\Addon',
        'block' => '\app\addons\block\Addon',
        'required' => '\app\addons\required\Addon',
        'ueditor' => '\app\addons\ueditor\Addon',
        'qiniu' => '\app\addons\qiniu\Addon',
        'user' => '\app\addons\user\Addon',
        'asset' => '\app\addons\asset\Addon',
        'page' => '\app\addons\page\Addon'
    ],
    'components' => [
        'view' => [
            'class' => 'app\kit\core\CoreView',
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
                'login'
            ]
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
            'class' => 'app\kit\components\AppMailer'
        ]
    ]
];

return $config;
