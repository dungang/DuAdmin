<?php
// 数据库配置放在具体的项目中是方便项目独立配置，项目之间相互隔离
$db = require __DIR__ . '/../../config/db.php';
$config = [
    'controllerNamespace' => 'app\frontend\controllers',
    'viewPath' => '@app/frontend/views',
    'components' => [
        'request' => [
            'cookieValidationKey' =>  getenv('APP_KEY'),
            'enableCsrfCookie' => false
        ],
        'session' =>[
            'name'=>'MMAFESID'
        ],
        'db' => $db,
        'user' => [
            'identityClass' => '\app\frontend\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => [
                'login'
            ]
        ],
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

        'view' => [
            'class' => 'app\mmadmin\core\CoreView',
            'theme' => [
                'class' => 'app\mmadmin\components\MATheme',
                'basePath' => '@app/themes/basic',
                'pathMap' => [
                    '@app/frontend/views' => '@app/themes/basic',
                ]
            ]
        ],
        'urlManager' => [
            'class' => 'app\mmadmin\components\RewriteUrl',
            //'cache' => 'cache',
            //'suffix' => '.html',
            'enablePrettyUrl' => true,
            'from_db' => true,
            'rules' => [
                '<slug:[\w \-]+>' => 'site/page'
            ]
        ],
        'assetManager' => [
            'class' => 'app\mmadmin\core\CoreAssetManager',
            'basePath' => '@app/public/assets'
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => '\yii\i18n\DbMessageSource'
                ],
            ],
        ],
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
