<?php

namespace Frontend\Forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $fullName;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // fullName, email, subject and body are required
            [['fullName', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => \Yii::t('app', 'Verification Code'),
            'fullName' => \Yii::t('app', 'Full Name'),
            'subject' => \Yii::t('app', 'Subject'),
            'email' => \Yii::t('app', 'Email'),
            'body' => \Yii::t('app', 'Body'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([getenv('MAIL_USERNAME') => getenv('MAIL_ALIAS')])
            ->setReplyTo([$this->email => $this->fullName])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
