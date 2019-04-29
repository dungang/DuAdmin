<?php
$db = require __DIR__ . '/db.php';
$config = [
    'modules'=>[
        'cms'=>'\app\addons\cms\CmsModule',
        'travel'=>'\app\addons\travel\TravelModule',
    ],
    'components' => [
        'db' => $db,
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'assetManager' => [
            'class'=>'\app\kit\core\CoreAssetManager',
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
