<?php

namespace DuAdmin\Widgets;

use DuAdmin\Assets\CropperAsset;
use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\helpers\Url;
use DuAdmin\Uploader\ConfigWidget;
use yii\helpers\Json;

class AjaxFileInput extends InputWidget
{

    /**
     * 文件类型
     *
     * @var string
     */
    public $type = "image";

    /**
     * 是否裁剪
     *
     * @var string 'true' or 'false'
     */
    public $clip = 'true';

    /**
     * 是否压缩
     *
     * @var string 'true' or 'false'
     */
    public $compress = 'true';

    /**
     * 裁剪后的宽度
     *
     * @var integer
     */
    public $clipWidth = 320;

    /**
     * 裁剪后的高度
     *
     * @var integer
     */
    public $clipHeight = 320;

    public $accept = "image/*";

    /**
     * 是否支持多图片上传
     */
    public $isMulti = false;

    /**
     * 多文件上传的时候，存储的格式
     * 默认是string，只存储 url
     * 设置为json,则存储{url:url,name:'文件的原始名称'}
     */
    public $multiFormat = 'string';

    /**
     * 是否只读
     *
     * @var boolean
     */
    public $readOnly = false;

    public function run()
    {
        // 配置前端参数
        ConfigWidget::factory();
        CropperAsset::register($this->view);
        if ($this->readOnly) {
            $this->options['readonly'] = 'readonly';
        }
        $this->options['data-type'] = $this->type;
        $this->options['data-token-url'] = Url::to([
            '/site/upload-token'
        ]);
        $src = '';
        if ($this->hasModel()) {
            $src = $this->model[$this->attribute];
            $input = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $src = $this->value;
            $input = Html::textInput($this->name, $this->value, $this->options);
        }
        if ($src) {
            if ($this->multiFormat == 'json') {
                $src = Json::decode("[" . $src . "]");
            } else {
                $src = explode(",", $src);
            }
        }
        return $this->render('ajax-file-input', [
            'isImage' => $this->type === 'image',
            'src' => $src,
            'input' => $input,
            'options' => [
                'data-multi' => $this->isMulti ? 'true' : 'false',
                'data-multi-format' => $this->multiFormat,
                'data-compress' => $this->compress,
                'data-clip' => $this->clip,
                'data-image-height' => $this->clipHeight,
                'data-image-width' => $this->clipWidth,
                'data-accept' => $this->accept
            ]
        ]);
    }
}
