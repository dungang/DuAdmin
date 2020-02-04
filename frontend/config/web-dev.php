<?php

use app\kit\core\Application;

$db = require __DIR__ . '/../../config/db-dev.php';
$config = [
    'mode'=> Application::MODE_FRONTEND,
    'controllerNamespace' => 'app\frontend\controllers',
    'viewPath'=>'@app/frontend/views',
    'components' => [
        'db' => $db,
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/frontend/app.log',
                    'levels' => [
                        'error',
                        'warning'
                    ]
                ]
            ]
        ],
        'urlManager' => [
            'class' => 'app\kit\components\RewriteUrl',
            //'cache' => 'cache',
            //'suffix' => '.html',
            'enablePrettyUrl' => true,
            'rules' => [
                '<slug:[\w \-]+>' => 'site/page/'
            ]
        ],
        'assetManager' => [
            'class' => 'app\kit\core\CoreAssetManager',
            'basePath' => '@app/public/assets'
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module'
        // 'panels'=>['log' => ['class' => 'yii\debug\panels\LogPanel']],
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
