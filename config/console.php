<?php
$db = require 'db.php';
$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'app\mmadmin\components\Bootstrap'
    ],
    'controllerNamespace' => 'app\console',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@Addons' => '@app/addons'
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
