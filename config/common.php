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
        'mailbox'=>'app\addons\mailbox\Addon',
        'cms' => '\app\addons\cms\Addon',
        //'card' => '\app\addons\card\Addon',
        'alipay' => '\app\addons\alipay\Addon',
        'ocr' => '\app\addons\ocr\Addon',
        'drug' => '\app\addons\drug\Addon',
        'mmh' => '\app\addons\mmh\Addon',
        // 'travel' => '\app\addons\travel\Addon',
        'taobaoke' => '\app\addons\taobaoke\Addon',
        // 'form' => '\app\addons\form\Addon',
        // 'wechat' => '\app\addons\wechat\Addon',
        //'merchant' => '\app\addons\merchant\Addon',
        //'shoukuan' => '\app\addons\shoukuan\Addon',
        'ueditor' => '\app\addons\ueditor\Addon',
        //'finance' => '\app\addons\finance\Addon',
        //'aliyun-oss' => '\app\addons\aliyunoss\Addon',
        'qiniu' => '\app\addons\qiniu\Addon',
        'user' => '\app\addons\user\Addon',
        'asset' => '\app\addons\asset\Addon',
        'page' => '\app\addons\page\Addon',
        'oauth' => '\app\addons\oauth\Addon'
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
