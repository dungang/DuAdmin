<?php
namespace DuAdmin\Widgets;

use yii\bootstrap\Widget;
use DuAdmin\Assets\InlineAttachmentAsset;
use yii\web\JsExpression;

class InlineAttachment extends Widget
{

    public $uploadUrl = '';

    public $progressText = '<img src="图片上传中..." />';

    public $urlText = '<img src="{filename}" alt="图片" class="img-thumbnail" />';

    public $errorText = '图片删除失败';

    public $allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/jpg',
        'image/gif'
    ];

    public function run()
    {
        $request = \Yii::$app->getRequest();
        InlineAttachmentAsset::register($this->view);
        $this->clientOptions['uploadUrl'] = $this->uploadUrl;
        $this->clientOptions['errorText'] = $this->errorText;
        $this->clientOptions['progressText'] = $this->progressText;
        $this->clientOptions['urlText'] = $this->urlText;
        $this->clientOptions['allowedTypes'] = $this->allowedTypes;
        $this->clientOptions['onFileUploadError'] = new JsExpression("function(res){ alert('上传失败');console.log(res); return false;}");
        $this->clientOptions['extraParams'] = [
            $request->csrfParam => $request->getCsrfToken()
        ];
        $this->registerPlugin('inlineattachment');
    }
}

