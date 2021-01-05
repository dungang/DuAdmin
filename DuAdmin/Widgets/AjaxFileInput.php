<?php
namespace DuAdmin\Widgets;

use DuAdmin\Assets\CropperAsset;
use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\helpers\Url;
use DuAdmin\Uploader\ConfigWidget;

class AjaxFileInput extends InputWidget
{

    /**
     * 文件类型
     *
     * @var string
     */
    public $type = "image";

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
        if ($this->hasModel()) {
            $input = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $input = Html::textInput($this->name, $this->value, $this->options);
        }
        return $this->render('ajax-file-input', [
            'input' => $input,
            'options' => [
                'data-compress' => $this->compress,
                'data-image-height' => $this->clipHeight,
                'data-image-width' => $this->clipWidth,
            ]
        ]);
    }
}
