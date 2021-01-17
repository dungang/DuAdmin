<?php

namespace DuAdmin\Uploader;

use yii\base\Model;
use DuAdmin\Helpers\AppHelper;
use yii\web\BadRequestHttpException;
use yii\helpers\FileHelper;
use DuAdmin\Core\BizException;

/**
 * 上传文件模型
 * @author dungang
 *
 */
class UploadForm extends Model
{
    public $key;

    public $file;

    public function rules()
    {
        $extensions = AppHelper::getSetting('system.storage.extensions');
        $extensions = empty($extensions) ? 'jpg,png' : $extensions;
        return [
            [['key', 'file'], 'required'],
            [['key'], 'string'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => $extensions],
        ];
    }

    public function upload()
    {
        \Yii::$app->response->format = 'json';
        if ($this->validate()) {
            $key = trim($this->key, '.');
            if (strpos($key, '..') === false) {
                $dist = \Yii::getAlias("@webroot/" . $key);
                $distDir = dirname($dist);
                if (!is_dir($distDir)) {
                    FileHelper::createDirectory($distDir);
                }
                try {
                    $this->file->saveAs($dist);
                    return [
                        "url" => $key
                    ];
                } catch (\Exception $ex) {
                    \Yii::error($ex->getMessage());
                }
                return null;
            } else {
                throw new BadRequestHttpException();
            }
        } else {
            throw new BizException(array_values($this->firstErrors)[0]);
        }
    }
}