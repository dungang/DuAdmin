<?php

namespace DuAdmin\Validators;

use Yii;
use yii\validators\Validator;

/**
 * 短信和邮件验证码验证器
 */
class SendCaptchaValidator extends Validator
{
    public $mode = 'sms';

    public $length = 6;

    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (strlen($value) != $this->length) {
            $model->addError($attribute, '验证码格式不正确');
        }
        $originValue = $this->getOriginValue($attribute);
        if ($originValue !== $value) {
            $model->addError($attribute, '验证码错误');
        }
    }

    protected function getOriginValue($attribute)
    {
        return Yii::$app->cache->get("sys-" . $this->mode . '-captcha:' . $attribute);
    }

    protected function deleteOriginValue($attribute)
    {
        Yii::$app->cache->delete("sys-" . $this->mode . '-captcha:' . $attribute);
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        return <<<JS
if(value.length == $this->length) {
    messages.push('验证码格式不正确');
}
JS;
    }
}
