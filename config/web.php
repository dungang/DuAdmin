<?php
$db = require __DIR__ . '/db.php';
$config = [
    'modules' => [
        'qiniu' => '\app\addons\qiniu\QiniuModule',
        'ueditor' => '\app\addons\ueditor\UeditorModule',
        'finance' => '\app\addons\finance\FinanceModule',
        'user' => '\app\addons\user\UserModule',
        'asset' => '\app\addons\asset\AssetModule',
        'page' => '\app\addons\page\PageModule',
        'oauth' => '\app\addons\oauth\OauthModule',
        'cms' => '\app\addons\cms\CmsModule'
    ],
    'components' => [
        'db' => $db,
        'errorHandler' => [
            'errorAction' => 'site/error'
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
        'assetManager' => [
            'class' => '\app\kit\core\CoreAssetManager'
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module'
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
