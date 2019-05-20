<?php

$db = require __DIR__ . '/db-dev.php';
$config = [
    'modules' => [
        'cms' => '\app\addons\cms\CmsModule',
        'travel' => '\app\addons\travel\TravelModule',
        'taobaoke' => '\app\addons\taobaoke\TaobaokeModule',
        'form' => '\app\addons\form\FormModule',
        'wechat' => '\app\addons\wechat\WechatModule',
        'school' => '\app\addons\school\SchoolModule',
        'ueditor' => '\app\addons\ueditor\UeditorModule',
        'aliyun-oss' => '\app\addons\aliyunoss\AliyunOssModule',
    ],
    'components' => [
        'db' => $db,
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'assetManager' => [
            'class' => '\app\kit\core\CoreAssetManager',
            'basePath' => '@app/public/assets',
        ],
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        //'panels'=>['log' => ['class' => 'yii\debug\panels\LogPanel']],
            // uncomment the following to add your IP if you are not connecting from localhost.
            // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'app\generators\Module',
        'generators' => [
            'crud' => [
                'class' => 'app\generators\crud\Generator',
            ],
            'model' => [
                'class' => 'app\generators\model\Generator',
                'baseClass' => 'app\kit\core\BaseModel',
                'ns' => 'app\kit\models',
                'queryNs' => 'app\kit\models'
            ],
            'addons' => [
                'class' => 'app\generators\addons\Generator',
            ]
        ]
            // uncomment the following to add your IP if you are not connecting from localhost.
            // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
