<?php
namespace app\backend\controllers;

use app\kit\core\BackendController;
use app\kit\helpers\KitHelper;

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

    /**
     * inline uploader
     *
     * @param string $fileType
     * @return \yii\web\Response
     */
    public function actionInline($fileType = 'image')
    {
        try {
            $rst = KitHelper::saveAttachment($fileType, 'file');
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
            $rst = KitHelper::saveAttachment('image', 'file');
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