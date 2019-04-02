<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=woniu-cms',
    //'dsn' => 'mysql:host=localhost;dbname=softmanage',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8mb4',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache'
];
