<?php

namespace Console\Components;

use Yii;
use yii\db\Migration as DbMigration;

class Migration extends DbMigration
{

    public function init()
    {
        if (RUNTIME_MODE !== 'Console') {
            $this->compact = true;
        }
        parent::init();
    }

    /**
     * This method contains the logic to be executed when applying this migration.
     * Child classes may override this method to provide actual migration logic.
     * @return bool return a false value to indicate the migration fails
     * and should not proceed further. All other return values mean the migration succeeds.
     */
    public function up()
    {
        $transaction = $this->db->beginTransaction();
        try {
            if ($this->safeUp() === false) {
                $transaction->rollBack();
                return false;
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $this->handleException($e);
            $transaction->rollBack();
            return false;
        } catch (\Throwable $e) {
            $this->handleException($e);
            $transaction->rollBack();
            return false;
        }

        return null;
    }

    /**
     * This method contains the logic to be executed when removing this migration.
     * The default implementation throws an exception indicating the migration cannot be removed.
     * Child classes may override this method if the corresponding migrations can be removed.
     * @return bool return a false value to indicate the migration fails
     * and should not proceed further. All other return values mean the migration succeeds.
     */
    public function down()
    {
        $transaction = $this->db->beginTransaction();
        try {
            if ($this->safeDown() === false) {
                $transaction->rollBack();
                return false;
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $this->handleException($e);
            $transaction->rollBack();
            return false;
        } catch (\Throwable $e) {
            $this->handleException($e);
            $transaction->rollBack();
            return false;
        }

        return null;
    }

    /**
     * @param \Throwable|\Exception $e
     */
    private function handleException($e)
    {
        if (RUNTIME_MODE !== 'Console') {
            Yii::error('Exception: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ")");
            Yii::error($e->getTraceAsString());
        } else {
            echo 'Exception: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ")\n";
            echo $e->getTraceAsString() . "\n";
        }
    }

    /**
     * Builds and executes a SQL statement for dropping a DB table.
     * @param string $table the table to be dropped. The name will be properly quoted by the method.
     */
    public function dropTable($table)
    {
        $time = $this->beginCommand("drop table $table");
        if ($this->tableExisted($table)) {
            $this->db->createCommand()->dropTable($table)->execute();
        } else {
            if (RUNTIME_MODE !== 'Console') {
                Yii::warning('table <' . $table . '> not existed!');
            } else {
                echo "table <" . $table . "> not existed!\n";
            }
        }
        $this->endCommand($time);
    }

    public function tableExisted($table)
    {
        $command =  $this->db->createCommand("SELECT count(*) FROM INFORMATION_SCHEMA.TABLES WHERE table_schema=:tableSchema AND TABLE_NAME = :tableName")
            ->bindValues([
                ':tableSchema' => getenv('DB_DATABASE'),
                ':tableName' => $this->formatTableName($table)
            ]);
        return $command->queryScalar();
    }

    public function formatTableName($tableName)
    {
        return preg_replace_callback(
            '/(\\{\\{(%?[\w\-\. ]+%?)\\}\\})/',
            function ($matches) {
                return str_replace('%', $this->db->tablePrefix, $matches[2]);
            },
            $tableName
        );
    }
}
