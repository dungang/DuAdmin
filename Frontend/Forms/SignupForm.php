<?php

namespace Frontend\Forms;

use DuAdmin\Core\BizException;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Helpers\MailHelper;
use Frontend\Models\User;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;

    public $email;

    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\Frontend\Models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\Frontend\Models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 8],
        ];
    }


    public function attributeLabels()
    {
        return [
            'username' => '账号',
            'password' => '密码',
            'email' => 'E-mail',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        $rst = $user->save() && $this->sendEmail($user);
        if ($user->hasErrors()) {
            Yii::error($user->errors);
            throw new BizException("保存失败");
        }
        return $rst;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        $template = MailHelper::getMailContent('sys_register_verify_mail', [
            '{username}' => $user->username,
            'verifyLink' => Yii::$app->urlManager->createAbsoluteUrl([
                'site/verify-email', 'token' => $user->verificationToken
            ])
        ]);
        return MailHelper::sendEmail(
            [AppHelper::getSetting('email.username') => AppHelper::getSetting('email.userAlias')],
            $user->email,
            $template['title'],
            $template['content']
        );
    }
}
