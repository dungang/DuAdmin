<?php

namespace DuAdmin\Sms;

use DuAdmin\Core\BizException;
use DuAdmin\Helpers\AppHelper;
use Yii;
use yii\base\Action;

class SendSmsCaptchaAction extends Action
{

    public function run()
    {
        $number = Yii::$app->request->post("reciever");
        if ($number) {
            $smsDriverClass = AppHelper::getSetting("system.sms.driver");
            if ($smsDriverClass) {
                $driver = new $smsDriverClass();
                $captcha = Yii::$app->security->generateRandomKey(6);
                call_user_func([$driver, 'send'], $number, $captcha);
                return [];
            } else {
                throw new BizException("短信服务异常");
            }
        }
        throw new BizException("请输入手机号码");
    }
}
