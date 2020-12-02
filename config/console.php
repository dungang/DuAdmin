<?php
$db = require 'db.php';
$basePath = dirname(__DIR__);
$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'DuAdmin\Components\Bootstrap'
    ],
    'controllerNamespace' => 'Console',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@Addons' => $basePath . '/Addons',
        '@DuAdmin' => $basePath . '/DuAdmin',
        '@Backend' => $basePath . '/Backend',
        '@Frontend' => $basePath . '/Frontend',
        '@Api' => $basePath . '/Api',
        '@Console' => $basePath . '/Console',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache'
        ],
        'log' => [
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
        'db' => $db,
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ]
    ]
    /*
 * 'controllerMap' => [
 * 'fixture' => [ // Fixture generation command line.
 * 'class' => 'yii\faker\FixtureController',
 * ],
 *
 * ],
 */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
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
