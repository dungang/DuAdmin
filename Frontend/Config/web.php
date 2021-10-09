<?php
$theme_name = getenv( 'THEME_NAME' );
$config = [
    'controllerNamespace' => 'Frontend\Controllers',
    'viewPath'            => '@Frontend/Views',
    'components'          => [
        'request'    => [
            'cookieValidationKey' => getenv( 'APP_KEY' ),
            'enableCsrfCookie'    => false
        ],
        'session'    => [
            'name' => 'DUAFSID'
        ],
        'user'       => [
            'identityClass'   => 'Frontend\Models\User',
            'enableAutoLogin' => true,
            'loginUrl'        => [
                'login'
            ]
        ],
        'view'       => [
            'theme' => [
                'class'   => 'DuAdmin\Components\DUATheme',
                'name'    => $theme_name,
                // 'basePath' => '@app/Themes/' . $theme_name,
                'pathMap' => [
                    '@Frontend/Views' => '@app/Themes/' . $theme_name,
                    '@Addons'         => '@app/Themes/' . $theme_name . '/addons'
                ]
            ]
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'urlManager' => [
            'class'           => 'DuAdmin\Components\PrettyUrlManager',
            'suffix'          => '.html',
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '<slug:[\w\-]+>'        => 'site/page',
               // 'cms/post/show-<id:\d+>' => 'cms/post/show'
            ]
        ],
        'log'        => [
            'targets' => [
                [
                    'class'   => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/frontend/app.log',
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
        'class' => 'DuAdmin\Components\DebugModule' // 'panels'=>['log' => ['class' => 'yii\debug\panels\LogPanel']],
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}
return $config;
