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
}
