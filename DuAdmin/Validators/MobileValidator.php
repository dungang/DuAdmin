<?php

namespace DuAdmin\Validators;

use yii\validators\Validator;

/**
 * 手机号码验证
 */
class MobileValidator extends Validator
{

    public $pattern = "/^1[34578]\d{9}$/";

    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (preg_match($this->pattern, $value) == false) {
            $model->addError($attribute, '不正确的手机号码');
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        return <<<JS

var pattern = $this->pattern;
if(pattern.test(value) ===false) {
    messages.push('不正确的手机号码');
}

JS;
    }
}
