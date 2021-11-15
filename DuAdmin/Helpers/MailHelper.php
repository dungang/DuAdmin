<?php

namespace DuAdmin\Helpers;

use DuAdmin\Core\BizException;
use DuAdmin\Models\MailTemplate;
use Yii;

class MailHelper
{

    public static function getMailContent($unicode, $vars)
    {
        $template = MailTemplate::find()
            ->select("title,content,varsInfo")
            ->where(['code' => $unicode])
            ->asArray()->one();
        if ($template) {
            $template['title'] = strtr($template['title'], $vars);
            $template['content'] = strtr($template['content'], $vars);
            return $template;
        } else {
            throw new BizException("邮件模板没找到");
        }
    }

    public static function sendEmail($from, $to, $subject, $content)
    {
        return Yii::$app
            ->mailer
            ->compose('mail', ['subject' => $subject, 'content' => $content])
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
}
