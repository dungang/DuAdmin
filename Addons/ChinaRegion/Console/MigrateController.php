<?php

namespace Addons\ChinaRegion\Console;

use yii\console\controllers\MigrateController as ControllersMigrateController;

class MigrateController extends ControllersMigrateController
{
    public $migrationPath = ['@Addons/ChinaRegion/Migrations'];

    public $app = "ChinaRegion";

    /**
     * {@inheritdoc}
     */
    public $templateFile = '@Console/views/migration.php';
}
