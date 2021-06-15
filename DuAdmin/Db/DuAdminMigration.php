<?php
namespace DuAdmin\Db;

use yii\db\Migration;

/**
 * 数据迁移
 *
 * @author admin
 *
 */
class DuAdminMigration extends Migration
{

    public function insertReturnId($table, $columns)
    {
        $time = $this->beginCommand("insert into $table");
        $id = $this->db->createCommand()
            ->insert($table, $columns)
            ->execute();
        $this->endCommand($time);
        return $id;
    }
}

