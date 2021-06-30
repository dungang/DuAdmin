<?php

$config = [
    'controllerNamespace' => 'Backend\Controllers',
    'viewPath'            => '@Backend/Views',
    'defaultRoute'        => 'default',
    'language'            => 'zh-CN',
    'components'          => [
        'request'     => [
            'cookieValidationKey' => getenv( 'APP_KEY' ),
            'enableCsrfCookie'    => false
        ],
        'session'     => [
            'name' => 'DUABSID'
        ],
        'authManager' => [
            'class' => 'DuAdmin\Rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            'cache' => 'cache'
        ],
        'actionLog'   => [
            'class' => 'DuAdmin\Components\ActionLog'
        ],
        'user'        => [
            'identityClass'   => '\Backend\Models\Admin',
            'enableAutoLogin' => true,
            'loginUrl'        => [
                'login'
            ]
        ],
        'urlManager'  => [
            'class' => 'DuAdmin\Components\DuaUrlManager'
        ],
        'log'         => [
            'targets' => [
                [
                    'class'   => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/backend/app.log',
                    'levels'  => explode( ',', getenv( 'LOG_LEVELS' ) )
                ]
            ]
        ]
    ]
];
if ( YII_ENV_DEV ) {
    // configuration adjustments for 'dev' environment
    $config[ 'bootstrap' ][] = 'debug';
    $config[ 'modules' ][ 'debug' ] = [
        'class' => 'yii\debug\Module' // 'panels'=>['log' => ['class' => 'yii\debug\panels\LogPanel']],
            // uncomment the following to add your IP if you are not connecting from localhost.
            // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    $config[ 'bootstrap' ][] = 'gii';
    $config[ 'modules' ][ 'gii' ] = [
        'class'      => 'app\generators\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => [
            '127.0.0.1',
            '::1'
        ]
    ];
}
return $config;
