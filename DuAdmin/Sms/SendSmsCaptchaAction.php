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
        $receiver = Yii::$app->request->post("receiver");
        if ($receiver) {
            $smsDriverClass = AppHelper::getSetting("system.sms.driver");
            if ($smsDriverClass) {
                $driver = new $smsDriverClass();
                $captcha = mt_rand(100000,999999);
                Yii::$app->cache->set('sys-sms-captcha:' . $receiver, $captcha, 3000);
                call_user_func([$driver, 'send'], $receiver, $captcha);
                return [];
            } else {
                throw new BizException("短信服务异常");
            }
        }
        throw new BizException("请输入手机号码");
    }
}
