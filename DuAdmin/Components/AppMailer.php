<?php

namespace DuAdmin\Components;

use yii\swiftmailer\Mailer;
use DuAdmin\Models\Setting;

/**
 * 邮件组件
 * @author dungang
 *
 */
class AppMailer extends Mailer
{

    /**
     *
     * {@inheritdoc}
     * @see \yii\base\BaseObject::init()
     */
    public function init()
    {
        $this->useFileTransport = false;
        $this->transport = [
            'class' => 'Swift_SmtpTransport',
            'host' => getenv('MAIL_HOST'),
            'username' => getenv('MAIL_USERNAME'),
            'password' => getenv('MAIL_PASSWORD'),
            'port' => getenv('MAIL_PORT')
        ];
    }
}
