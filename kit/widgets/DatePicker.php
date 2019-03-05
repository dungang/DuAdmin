<?php
namespace app\kit\widgets;

use app\kit\assets\DatePickerAsset;
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
    public $embed = false;

    public $format = 'yyyy-mm-dd';

    private $trans = array(
        'dd' => 'd',
        'mm' => 'm',
        'yyyy' => 'Y',
        'd' => 'j'
    );

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
            'autoclose' => true,
            'zIndexOffset' => 10000,
            'todayBtn' => 'linked',
            'todayHighlight' => true,
            'clearBtn' => true
        ], $this->clientOptions);
        $this->clientOptions['language'] = \Yii::$app->language;
        $this->clientOptions['format'] = $this->format;
        DatePickerAsset::register($this->view);
        $this->registerPlugin('datepicker');
        if ($this->embed == false) {
            if ($this->hasModel()) {
                if (is_numeric($this->model[$this->attribute])) {
                    $this->model[$this->attribute] = date($this->convertFormat(), $this->model[$this->attribute]);
                }
                return Html::activeTextInput($this->model, $this->attribute, $this->options);
            } else {
                if (is_numeric($this->value)) {
                    $this->value = date($this->convertFormat(), $this->value);
                }
                return Html::textInput($this->id, $this->value, $this->options);
            }
        } else {
            return Html::tag('div', '', $this->options);
        }
    }
}

