<?php
$db = require __DIR__ . '/db-dev.php';
$config = [
    'modules'=>[
        'taobaoke'=>'\app\addons\taobaoke\TaobaokeModule',
    ],
    'components' => [
        'db' => $db,
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'assetManager' => [
            'basePath'=>'@app/public/assets',
            'bundles' => [
                'yii\bootstrap\BootstrapPluginAsset' => [
                    //'baseUrl' => 'https://cdn.bootcss.com/twitter-bootstrap/3.4.1/',
                    'baseUrl' => '@web',
                    'js' => [
                        'js/bootstrap.min.js',
                    ],
                    'sourcePath' => null // 防止在 frontend/web/asset 下生产文件
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    //'baseUrl' => 'https://cdn.bootcss.com/twitter-bootstrap/3.4.1/',
                    'baseUrl' => '@web',
                    'css' => [
                        'css/bootstrap.min.css',
                    ],
                    'sourcePath' => null // 防止在 frontend/web/asset 下生产文件
                ]
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
