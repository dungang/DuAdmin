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
