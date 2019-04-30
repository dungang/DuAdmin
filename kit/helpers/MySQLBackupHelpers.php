<?php

namespace app\kit\helpers;

use Yii;
use yii\db\Exception;
use yii\base\UnknownClassException;
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

    /**
     * Charge method to backup and create a zip with this
     */
    public static function createZipBackup($file_name)
    {
        $zip = self::getZipResource();
        $file = $file_name . '.zip';
        if ($zip->open($file, \ZipArchive::CREATE) === TRUE) {
            $zip->addFile($file_name, basename($file_name));
            $zip->close();
            @unlink($file_name);
        }
    }

    /**
     * 读取目录的文件，并添加到zip压缩文件中
     *
     * @param \ZipArchive $zip
     * @param string $new_dir_name
     * @param string $directory
     * @return void
     */
    public static function zipDirectory($zip, $new_dir_name, $directory)
    {
        if ($handle = opendir($directory)) {
            while (($file = readdir($handle)) !== false) {
                if (is_dir($directory . $file) && $file != "." && $file != ".." && !in_array($directory . $file . '/', $this->module->excludeDirectoryBackup))
                    $this->zipDirectory($zip, $new_dir_name . $file . '/', $directory . $file . '/');

                if (is_file($directory . $file))
                    $zip->addFile($directory . $file, $new_dir_name . $file);
            }
            closedir($handle);
        }
    }

    /**
     * zip压缩文件
     *
     * @param string $sqlZipFile
     * @return string
     */
    public static function unzip($sqlZipFile)
    {
        if (file_exists($sqlZipFile)) {
            $zip = self::getZipResource();
            $result = $zip->open($sqlZipFile);
            if ($result === true) {
                $zip->extractTo(dirname($sqlZipFile));
                $zip->close();
                $sqlZipFile = str_replace(".zip", "", $sqlZipFile);
            }
        }
        return $sqlZipFile;
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

    /**
     * 获取zip资源
     *
     * @return \ZipArchive
     */
    private static function getZipResource()
    {
        if (class_exists(\ZipArchive::class)) {
            return new \ZipArchive();
        } else {
            throw new UnknownClassException("ZipArchive missing class");
        }
    }
}
