<?php
$theme_name = getenv('THEME_NAME');
$config = [
    'controllerNamespace' => 'Frontend\Controllers',
    'viewPath' => '@Frontend/views',
    'components' => [
        'request' => [
            'cookieValidationKey' => getenv('APP_KEY'),
            'enableCsrfCookie' => false
        ],
        'session' => [
            'name' => 'DJPFSID'
        ],
        'user' => [
            'identityClass' => 'Frontend\Models\User',
            'enableAutoLogin' => true,
            'loginUrl' => [
                'login'
            ]
        ],
        'view' => [
            'class' => 'DuAdmin\Core\CoreView',
            'theme' => [
                'class' => 'DuAdmin\Components\DUATheme',
                'basePath' => '@app/themes/' . $theme_name,
                'pathMap' => [
                    '@Frontend/views' => '@app/themes/' . $theme_name
                ]
            ]
        ],
        'urlManager' => [
            'class' => 'DuAdmin\Components\RewriteUrl',
            // 'suffix' => '.html',
            'rules' => [
                '<slug:[\w \-]+>' => 'site/page'
            ]
        ],
        'assetManager' => [
            'class' => 'DuAdmin\Core\CoreAssetManager',
            'basePath' => '@app/public/assets'
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/frontend/app.log',
                    'levels' => explode(',', getenv('LOG_LEVELS'))
                ]
            ]
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
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'app\generators\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => [
            '127.0.0.1',
            '::1'
        ]
    ];
}

return $config;
