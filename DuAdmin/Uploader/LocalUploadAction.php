<?php

namespace DuAdmin\Uploader;

use yii\base\Action;
use yii\web\UploadedFile;
use yii\web\BadRequestHttpException;

/**
 * 上传图片和文件
 */
class LocalUploadAction extends Action
{

    public function run()
    {
        $model = new UploadForm();
        if (\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post(), '')) {
            $model->file = UploadedFile::getInstanceByName('file');
            if ($data = $model->upload()) {
                return $data;
            }
        }
        throw new BadRequestHttpException();
    }
}
