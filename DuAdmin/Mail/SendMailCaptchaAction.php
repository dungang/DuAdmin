<?php

namespace DuAdmin\Mail;

use DuAdmin\Core\BizException;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Helpers\MailHelper;
use Yii;
use yii\base\Action;

/**
 * 邮件验证码
 * 缓存5分钟
 */
class SendMailCaptchaAction extends Action
{

    public function run()
    {
        $receiver = Yii::$app->request->post("receiver");
        if ($receiver) {
            $captcha = Yii::$app->security->generateRandomKey(6);
            Yii::$app->cache->set('sys-mail-captch:'.$receiver,$captcha,3000);
            $data = MailHelper::getMailContent('sys_mail_captcha', [
                '{captcha}' => Yii::$app->security->generateRandomKey(6)
            ]);
            MailHelper::sendEmail(
                getenv('MAIL_USERNAME'),
                $receiver,
                $data['title'],
                $data['content']
            );
        }
        throw new BizException("请输入邮箱账户");
    }
}
