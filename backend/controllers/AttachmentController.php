<?php
namespace app\backend\controllers;

use app\mmadmin\core\BackendController;
use app\mmadmin\components\FileUploader;

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
        ];
        $this->verbsActions = [
            'inline' => [
                'post'
            ],
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
}