<?php

namespace app\kit\helpers;

use Yii;
use yii\db\Exception;
use yii\helpers\FileHelper;

class MySQLBackupHelpers
{

    public static function generateBackupFile($dir)
    {
        if(!is_dir($dir)){
            FileHelper::createDirectory($dir);
        }
        return $dir . 'db_backup_' . date('Y.m.d_H.i.s') . '.sql';
    }

    /**
     * 处理备份
     *
     * @param [type] $backup_file_name
     * @return void
     */
    public static function backup($backup_file_name)
    {
        $file_resource = fopen($backup_file_name, 'w+');
        self::startBackup($file_resource);
        $tables = self::getTables();
        foreach ($tables as $table_name) {
            self::writeTableDefine($file_resource, $table_name);
            self::writeTableData($file_resource, $table_name);
        }
        self::endBackup($file_resource);
        fclose($file_resource);
        $file_resource = null;
    }

    /**
     * 读取备份文件，并执行sql
     *
     * @param [type] $backup_file_name
     * @return void
     */
    public static function restore($backup_file_name)
    {
        $message = "ok";
        if (file_exists($backup_file_name)) {
            $sqlArray = fopen($backup_file_name, "r");
            $str = fread($sqlArray, filesize($backup_file_name));
            $sql = preg_replace("#;{2,}#", ";", $str);
            $cmd = Yii::$app->db->createCommand($sql);
            try {
                $cmd->execute();
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }
        return $message;
    }

  

    private static function getTables()
    {
        return Yii::$app->db->createCommand('SHOW TABLES')->queryColumn();
    }

    private static function startBackup($file_resource)
    {
        fwrite($file_resource, '-- -------------------------------------------' . PHP_EOL);
        fwrite($file_resource, 'SET AUTOCOMMIT=0;' . PHP_EOL);
        fwrite($file_resource, 'START TRANSACTION;' . PHP_EOL);
        fwrite($file_resource, 'SET SQL_QUOTE_SHOW_CREATE = 1;' . PHP_EOL);
        fwrite($file_resource, 'SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;' . PHP_EOL);
        fwrite($file_resource, 'SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;' . PHP_EOL);
        fwrite($file_resource, '-- -------------------------------------------' . PHP_EOL);
        self::writeComment($file_resource, 'START BACKUP');
    }

    private static function endBackup($file_resource)
    {
        fwrite($file_resource, '-- -------------------------------------------' . PHP_EOL);
        fwrite($file_resource, 'SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;' . PHP_EOL);
        fwrite($file_resource, 'SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;' . PHP_EOL);
        fwrite($file_resource, 'COMMIT;' . PHP_EOL);
        fwrite($file_resource, '-- -------------------------------------------' . PHP_EOL);
        self::writeComment($file_resource, 'END BACKUP');
    }

    private static function writeTableDefine($file_resource, $table_name)
    {
        $sql = 'SHOW CREATE TABLE ' . $table_name;
        $cmd = Yii::$app->db->createCommand($sql);
        $table = $cmd->queryOne();
        $create_query = $table['Create Table'] . ';';
        $create_query = preg_replace('/^CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $create_query);
        $create_query = preg_replace('/AUTO_INCREMENT\s*=\s*([0-9])+/', '', $create_query);
        self::writeComment($file_resource, 'TABLE `' . addslashes($table_name) . '`');
        $final = 'DROP TABLE IF EXISTS `' . addslashes($table_name) . '`;' . PHP_EOL . $create_query . PHP_EOL . PHP_EOL;
        fwrite($file_resource, $final);
    }

    public static function writeTableData($file_resource, $table_name)
    {
        $sql = 'SELECT * FROM ' . $table_name;
        $cmd = Yii::$app->db->createCommand($sql);
        $dataReader = $cmd->query();

        self::writeComment($file_resource, 'TABLE DATA ' . $table_name);

        foreach ($dataReader as $data) {
            $item_names = array_keys($data);
            $item_names = array_map("addslashes", $item_names);
            $items = join('`,`', $item_names);
            $item_values = array_values($data);
            $item_values = array_map("addslashes", $item_values);
            $valueString = join("','", $item_values);
            $valueString = "('" . $valueString . "'),";
            $values = "\n" . $valueString;

            if ($values != "") {
                $data_string = "INSERT INTO `$table_name` (`$items`) VALUES" . rtrim($values, ",") . ";;;" . PHP_EOL;
                if ($file_resource)
                    fwrite($file_resource, $data_string);
            }
        }
        fflush($file_resource);
    }

    private static function writeComment($file_resource, $string)
    {
        fwrite($file_resource, '-- -------------------------------------------' . PHP_EOL);
        fwrite($file_resource, '-- ' . $string . PHP_EOL);
        fwrite($file_resource, '-- -------------------------------------------' . PHP_EOL);
    }

    
}
