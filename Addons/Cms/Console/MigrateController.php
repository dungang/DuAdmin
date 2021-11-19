<?php

namespace Addons\Cms\Console;

use yii\console\controllers\MigrateController as ControllersMigrateController;

class MigrateController extends ControllersMigrateController
{
    public $migrationPath = ['@Addons/Cms/Migrations'];

    public $app = "Cms";
    
    /**
    * {@inheritdoc}
    */
    public $templateFile = '@Console/views/migration.php';
}
