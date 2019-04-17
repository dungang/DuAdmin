<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=baiyuan-cms',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8mb4',
    'tablePrefix'=>'bai_',
    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache'
];
