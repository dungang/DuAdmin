<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=docdada',
    'username' => 'docdada',
    'password' => 'docdada!@#83',
    'charset' => 'utf8mb4',
    'tablePrefix'=>'ma_',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
