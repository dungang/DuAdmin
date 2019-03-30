<?php
namespace app\backend\controllers;

use app\kit\core\BackendController;
use app\kit\components\FileUploader;

/**
 * 后台默认支持的文件和图片上传的功能
 *
 * @author dungang
 */
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

    public function getFileUploader()
    {
        return new FileUploader([
            'file_type' => 'image',
            'field' => 'file'
            //             'thumbnail' => false,
            //             'thumb_width' => null,
            //             'thumb_height' => null,
            //             'thumb_mode' => 'outbound'
        ]);
    }

    /**
     * inline uploader
     *
     * @param string $fileType
     * @return \yii\web\Response
     */
    public function actionInline($fileType = 'image')
    {
        try {
            $rst = $this->getFileUploader()->upload();
            return $this->asJson([
                'filename' => $rst['url']
            ]);
        } catch (\Exception $e) {
            return $this->asJson([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Wang Editor image uploader
     *
     * @return \yii\web\Response
     */
    public function actionWangEditor()
    {
        try {
            $rst = $this->getFileUploader()->upload();
            return $this->asJson([
                'errno' => 0,
                'data' => [
                    $rst['url']
                ]
            ]);
        } catch (\Exception $e) {
            return $this->asJson([
                'errno' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }
}