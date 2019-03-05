<?php
namespace app\kit\components;

use yii\swiftmailer\Mailer;
use app\kit\models\Setting;

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

