<?php

use DuAdmin\Helpers\InstallerHelper;
use Console\Components\Migration;

/**
 * Class m201124_142814_init_uedit_config
 */
class m201124_142814_init_uedit_config extends Migration
{

    public $widgetName = '\Addons\Ueditor\Widget\Ueditor';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        InstallerHelper::InstallDict( 'system_editor', "系统编辑", [
            ['dictLabel' => '百度编辑器', 'dictValue' => $this->widgetName]
        ] );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        InstallerHelper::UninstallDictData( 'system_editor', $this->widgetName );
    }

}
