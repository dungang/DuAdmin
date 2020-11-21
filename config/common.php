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
        //'airline'=> 'app\addons\airline\Addon',
        //'clothes'=> 'app\addons\clothes\Addon',
        //'tbk'=> 'app\addons\tbk\Addon',
        'pdd'=> 'app\addons\pdd\Addon',
        'banxh'=> 'app\addons\banxh\Addon',
        //'gq'=> 'app\addons\gq\Addon',
        //'ocr' => 'app\addons\ocr\Addon',
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
