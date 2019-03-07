<?php
$db = require __DIR__ . '/db.php';
$config = [
    'components' => [
        'db' => $db,
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'baseUrl' => '@web',
                    'css' => [
                        'css/bootstrap.min.css',
                    ], // 去除 bootstrap.css
                    'sourcePath' => null // 防止在 frontend/web/asset 下生产文件
                ],
                
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'baseUrl' => '@web',
                    'js' => [
                        'js/bootstrap.min.js',
                    ],
                    'sourcePath' => null // 防止在 frontend/web/asset 下生产文件
                ],
            ]
        ],
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
