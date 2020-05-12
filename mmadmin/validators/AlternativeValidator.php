<?php

namespace app\mmadmin\validators;

use yii\validators\Validator;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\web\JsExpression;
use yii\helpers\Json;

/**
 * 可选字段验证器
 *
 * @author dungang
 */
class AlternativeValidator extends Validator
{

    /**
     * 可选字段
     *
     * @var string|array
     */
    public $alterAttributes;

    private $__target_model;

    private $__target_attribute;

    public function init()
    {
        parent::init();

        if (empty($this->alterAttributes)) {
            throw new InvalidConfigException('必须配置`alterAttributes`属性');
        } else if (\is_string($this->alterAttributes)) {
            $this->alterAttributes = \explode(',', $this->alterAttributes);
        }
    }

    protected function initMessageTemplate($attribute)
    {
        if ($this->message === null) {
            $holders = \implode(',', \array_map(function ($attr) {
                return '{' . $attr . '}';
            }, $this->alterAttributes));

            $this->message = $holders . ',{' . $attribute . '}' . '等项至少填写一项！';
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\validators\Validator::validateValue()
     */
    protected function validateValue($value)
    {
        if (!empty(trim($value))) {
            return null;
        } else {
            foreach ($this->alterAttributes as $attr) {
                if (!empty(trim($this->__target_model->$attr))) {
                    return null;
                }
            }
        }
        $params = $this->getAlterLabels($this->__target_model, $this->__target_attribute);
        foreach ($this->alterAttributes as $attr) {
            $this->addError($this->__target_model, $this->__target_attribute, $this->message, $params);
        }
        return [
            $this->message,
            $params
        ];
    }

    protected function getAlterLabels($model, $attribute)
    {
        $labels = [
            '{' . $attribute . '}' => $model->getAttributeLabel($attribute)
        ];
        $attrLabels = $model->attributeLabels();
        foreach ($this->alterAttributes as $attr) {
            $labels['{' . $attr . '}'] = $attrLabels[$attr];
        }
        return $labels;
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\validators\Validator::validate()
     */
    public function validate($value, &$error = null)
    {
        if (empty($this->__target_model)) {
            throw new NotSupportedException("可选验证器不支持临时验证");
        }
        return parent::validate($value, $error);
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\validators\Validator::validateAttribute()
     */
    public function validateAttribute($model, $attribute)
    {
        $this->__target_model = $model;
        $this->__target_attribute = $attribute;
        $this->initMessageTemplate($attribute);
        parent::validateAttribute($model, $attribute);
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\validators\Validator::validateAttributes()
     */
    public function validateAttributes($model, $attributes = null)
    {
        $this->__target_model = $model;
        parent::validateAttributes($model, $attributes);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $alterAttrs = [];
        foreach ($this->alterAttributes as $attr) {
            $alterAttrs[$attr] = $model->$attr;
        }
        return $this->prepareJs($model, $attribute, Json::encode($alterAttrs));
    }

    protected function prepareJs($model, $attribute, $alterAttrs)
    {
        $this->initMessageTemplate($attribute);
        $message = \strtr($this->message, $this->getAlterLabels($model, $attribute));
        return <<<JS
(function($,value,messages,message,attrs){
    if(!value || (value && value.trim() =='')){
        for(var p in attrs){
            if(attrs[p]){
                return true;
            }
        }
        messages.push(message);
        return false;
    }
    return true;
})(jQuery,value, messages,"${message}",$alterAttrs);
JS;
    }
}
