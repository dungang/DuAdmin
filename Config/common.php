<?php

$db = require 'db.php';
return [
    'id'         => 'base',
    'name'       => getenv( 'APP_NAME' ),
    'version'    => getenv( 'APP_VERSION' ),
    'basePath'   => dirname( __DIR__ ),
    'components' => [
        'db'           => $db,
        'cache'        => [
            'class' => 'yii\caching\FileCache'
        ],
        'errorHandler' => [
            'errorAction' => '/site/error'
        ]
    ]
];
