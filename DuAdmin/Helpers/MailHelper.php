<?php

namespace DuAdmin\Helpers;

use DuAdmin\Core\BizException;
use DuAdmin\Models\MailTemplate;
use Yii;

class MailHelper
{

    /**
     * 获取邮件的内容模板，并替换成邮件有内容
     *
     * @param string $unicode
     * @param array $vars
     * @return string|array
     */
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
            ->compose('content', ['subject' => $subject, 'content' => $content])
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
}
