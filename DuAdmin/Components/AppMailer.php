<?php
namespace DuAdmin\Components;

use yii\swiftmailer\Mailer;
use DuAdmin\Models\Setting;

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
            'host' => Setting::getSettings('email.host'),
            'username' => Setting::getSettings('email.username'),
            'password' => Setting::getSettings('email.password'),
            'port' => Setting::getSettings('email.port')
        ];
    }
}

