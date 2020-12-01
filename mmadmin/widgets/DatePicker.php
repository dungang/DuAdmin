<?php
namespace app\mmadmin\widgets;

use app\mmadmin\assets\DatePickerAsset;
use yii\bootstrap\InputWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * 日期选择控件
 *
 * @author dungang
 *        
 */
class DatePicker extends InputWidget
{

    /**
     * 是否嵌入到网页
     * @var bool
     */
    public $embed = false;

    /**
     * 格式化模板
     * @var string
     */
    public $format = 'yyyy-mm-dd';

    /**
     * 是否在输入框显示多个日期
     *
     * @var bool|int
     */
    public $multidate = false;

    /**
     * 多个日期的分隔符号
     *
     * @var string
     */
    public $multidateSeparator = '~';

    /**
     * 是否显示今日按钮
     *
     * @var bool
     */
    public $todayBtn = true;

    private $trans = array(
        'dd' => 'd',
        'mm' => 'm',
        'yyyy' => 'Y',
        'd' => 'j'
    );
    
    public static function rangeConfig(){
           return [
               'multidate'=>2
           ];
    }

    public function init()
    {
        parent::init();
        $this->options['class'] = 'form-control';
    }

    public function convertFormat()
    {
        return strtr($this->format, $this->trans);
    }

    public function run()
    {
        $this->clientOptions = ArrayHelper::merge([
            'autoclose' => false,
            'zIndexOffset' => 20,
            'todayBtn' => $this->todayBtn,
            'todayHighlight' => true,
            'clearBtn' => true,
            'multidate' => $this->multidate,
            'multidateSeparator' => $this->multidateSeparator
        ], $this->clientOptions);
        $this->clientOptions['language'] = \Yii::$app->language;
        $this->clientOptions['format'] = $this->format;
        DatePickerAsset::register($this->view);
        $this->registerPlugin('datepicker');
        if ($this->embed == false) {
            if ($this->hasModel()) {
                $value = $this->model[$this->attribute];
                if (is_numeric($value)) {
                    $this->model[$this->attribute] = date($this->convertFormat(), $value);
                } else if (is_array($value)) {
                    $this->model[$this->attribute] = date($this->convertFormat(), $value[0]);
                }
                return Html::activeTextInput($this->model, $this->attribute, $this->options);
            } else {
                if (is_numeric($this->value)) {
                    $this->value = date($this->convertFormat(), $this->value);
                } else if (is_array($this->value)) {
                    $this->value = date($this->convertFormat(), $this->value[0]);
                }
                return Html::textInput($this->id, $this->value, $this->options);
            }
        } else {
            return Html::tag('div', '', $this->options);
        }
    }
}
