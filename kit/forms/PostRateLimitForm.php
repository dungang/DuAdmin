<?php
namespace app\kit\forms;

use yii\base\Model;

/**
 *
 * @author dungang
 */
class PostRateLimitForm extends Model
{
    public $captcha;
    
    public function rules(){
        return [
            ['captcha','required'],
            ['captcha','captcha']
        ];
    }
    
    public function attributeLabels(){
        return [
            'captcha'=>'验证码'
        ];
    }
}

