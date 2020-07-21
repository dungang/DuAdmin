<?php

use app\mmadmin\core\Application;
// 数据库配置放在具体的项目中是方便项目独立配置，项目之间相互隔离
$db = require __DIR__ . '/../../config/db.php';
$config = [
    'mode' => Application::MODE_FRONTEND,
    'controllerNamespace' => 'app\frontend\controllers',
    'viewPath' => '@app/frontend/views',
    'modules' => [],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'dhkwehdihxlekdu@dkld',
        ],
        'session' =>[
            'name'=>'MAFESESSION'
        ],
        'db' => $db,
        'user' => [
            'identityClass' => '\app\mmadmin\models\User',
            'identityCookie' => ['name' => '_fe_id', 'httpOnly' => true],
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
                    '@app/frontend/views' => '@app/themes/basic'
                ]
            ]
        ],
        'urlManager' => [
            'class' => 'app\mmadmin\components\RewriteUrl',
            'cache' => 'cache',
            'showScriptName'=>false,
            //'suffix' => '.html',
            'from_db' => true,
            'enablePrettyUrl' => true,
            'rules' => [
                '<slug:[\w \-]+>' => 'site/page/',
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
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['115.198.128.213','127.0.0.1', '::1'],
    ];
}

return $config;
