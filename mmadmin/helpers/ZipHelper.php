<?php
namespace app\mmadmin\helpers;

use yii\base\UnknownClassException;

class ZipHelper
{

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
                if (is_dir($directory . $file) && $file != "." && $file != ".." && ! in_array($directory . $file . '/', $this->module->excludeDirectoryBackup))
                    self::zipDirectory($zip, $new_dir_name . $file . '/', $directory . $file . '/');

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