<?php
namespace app\backend\controllers;

use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use app\kit\core\BackendController;

class AttachmentController extends BackendController
{

    public function init()
    {
        parent::init();
        $this->userActions = [
            'inline',
            'wang-editor'
        ];
        $this->verbsActions = [
            'inline' => [
                'post'
            ],
            'wang-editor' => [
                'post'
            ]
        ];
    }

    /**
     * inline uploader
     * @param string $fileType
     * @return \yii\web\Response
     */
    public function actionInline($fileType = 'image')
    {
        try {
            return $this->asJson([
                'filename' => $this->saveAttachment($fileType, 'file')
            ]);
        } catch (\Exception $e) {
            return $this->asJson([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Wang Editor image uploader
     * @return \yii\web\Response
     */
    public function actionWangEditor()
    {
        try {
            return $this->asJson([
                'errno' => 0,
                'data' => [
                    $this->saveAttachment('image', 'file')
                ]
            ]);
        } catch (\Exception $e) {
            return $this->asJson([
                'errno' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }

    protected function saveAttachment($fileType = 'image', $fileField = 'file')
    {
        $file = UploadedFile::getInstanceByName($fileField);
        $dir = 'uploads/' . $fileType . '/' . Date('Y/m-d/');
        $url = $dir . uniqid($fileType, true) . '.' . $file->extension;
        $webroot = \Yii::getAlias("@webroot");
        $path = $webroot . '/' . $dir;
        if (! is_dir($path)) {
            FileHelper::createDirectory($path);
        }
        $file->saveAs($webroot . '/' . $url);
        return $url;
    }
}