<?php
namespace DuAdmin\Widgets;

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
     * 是否裁剪
     *
     * @var boolean
     */
    public $clip = false;

    /**
     * 裁剪后的宽度
     *
     * @var string
     */
    public $clipWidth = '100px';

    /**
     * 裁剪后的高度
     *
     * @var string
     */
    public $clipHeight = '100px';

    /**
     * 目标图片显示高度
     *
     * @var string
     */
    public $sourceImageHight = '300px';

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
            'input' => $input
        ]);
    }
}
