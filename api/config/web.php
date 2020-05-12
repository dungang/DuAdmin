<?php

use app\mmadmin\core\Application;

$db = require __DIR__ . '/db.php';
$config = [
    'mode' => Application::MODE_API,
    'controllerNamespace' => 'app\api\controllers',
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
            'class' => '\app\mmadmin\core\CoreAssetManager'
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
