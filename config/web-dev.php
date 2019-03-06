<?php
$db = require __DIR__ . '/db-dev.php';
$config = [
    'components' => [
        'db' => $db,
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'baseUrl' => '@web/css/',
                    'css' => [
                        'bootstrap-cosmo.min.css'
                    ], // 去除 bootstrap.css
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
                'templates' => [
                    'geetask' => dirname(dirname(__FILE__)) . '/generators/crud/default'
                ]
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
