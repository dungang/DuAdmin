<?php

namespace app\mmadmin\uploader;

use app\mmadmin\components\ApiActionChain;
use app\mmadmin\helpers\MAHelper;
use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;

/**
 * 上传图片和文件
 */
class LocalUploadAction extends Action
{

    public function run()
    {

        $allow_extensions = MAHelper::getSettingAry('uploader.allow_extensions');

        return ApiActionChain::getInstance()
            ->setFields([
                'dir' => Yii::t('ma', 'Save dir'),
                'file' => Yii::t('ma', 'File')
            ])
            ->setFieldsRules([
                [['dir', 'file'], 'required'],
                ['dir', 'string'],
                ['file', 'file', 'extensions' => $allow_extensions]
            ])->done(function ($params, $model) {
                $date = date('/Y/m/d/');
                if (FileHelper::createDirectory("@app/public/uploads" . $date)) {
                    $file = "uploads/" . $date . $model->dir . "/" . time() . '.' . $this->imageFile->extension;
                    $this->file->saveAs($file);
                }
                return null;
            });
    }
}
