<?php

use DuAdmin\Helpers\InstallerHelper;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%china_region}}`.
 */
class m211128_081130_china_region_create_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%china_region}}', [
            'id' => $this->integer()->comment('行政编码'),
            'pid' => $this->integer()->comment('上级行政编码'),
            'level' => $this->integer()->comment('级别::1:省级|2:市级|3:县级'),
            'name' => $this->string(128)->comment("名称"),
        ]);
        $this->addPrimaryKey('pk-china_region-id','{{%china_region}}','id');
        $this->addCommentOnTable('{{%china_region}}','中国行政编码');
        $dataFile = \Yii::$app->basePath . '/Addons/ChinaRegion/Resource/data.txt';
        if (file_exists($dataFile)) {
            $resource = fopen($dataFile, 'r');
            $lastPid1 = 0;
            $lastPid2 = 0;
            $lastPid3 = 0;
            while ($line = fgets($resource)) {
                $line = str_replace("\t"," ",str_replace("  "," ",trim($line)));
                $level = substr_count($line," ");
                list($id, $name) = preg_split("/\s+/", $line);
                if ($level == 1) {
                    $pid = $lastPid1;
                    $lastPid2 = $id;
                } else if ($level == 2) {
                    $pid = $lastPid2;
                    $lastPid3 = $id;
                } else if ($level == 3) {
                    
                    $pid = $lastPid3;
                    if($pid == 0) {
                        $pid = $lastPid2;
                    }
                }
                $this->insert("{{%china_region}}", [
                    'id' => $id,
                    'pid' => $pid,
                    'level' => $level,
                    'name' => trim($name)
                ]);
            }
            fclose($resource);
        } else {
            throw new Exception("文件不存在: ". $dataFile ." . \n");
        }

        InstallerHelper::installAddonPermission('addon-china-region', '中国行政区模块管理');
        InstallerHelper::installPermissionCRUDShortcut('行政区管理', 'china-region/default/index','addon-china-region');
         //初始化菜单
        InstallerHelper::installMenus([
            [
                'name'     => '行政区',
                'icon'     => 'fa fa-map',
                'url'  => 'china-region/default',
            ]
        ],10, "addon-china-region");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%china_region}}');
    }
}
