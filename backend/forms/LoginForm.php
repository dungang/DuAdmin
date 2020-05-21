<?php
namespace app\backend\forms;

use Yii;
use yii\base\Model;
use app\backend\models\Admin;

/**
 * LoginForm is the model behind the login form.
 *
 * @property Admin|null $user This property is read-only.
 */
class LoginForm extends Model
{

    public $username;

    public $password;

    public $rememberMe = true;

    public $captcha;

    private $_user = false;

    /**
     *
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [
                [
                    'username',
                    'password',
                    'captcha'
                ],
                'required'
            ],
            // rememberMe must be a boolean value
            [
                'rememberMe',
                'boolean'
            ],
            // password is validated by validatePassword()
            [
                'password',
                'validatePassword'
            ],
            [
                'captcha',
                'captcha'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '账号',
            'password' => '密码',
            'rememberMe' => '记住我',
            'captcha' => '验证码'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute
     *            the attribute currently being validated
     * @param array $params
     *            the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (! $this->hasErrors()) {
            $user = $this->getAdmin();

            if (! $user || ! $user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getAdmin(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return Admin|null
     */
    public function getAdmin()
    {
        if ($this->_user === false) {
            $this->_user = Admin::findByUsername($this->username);
        }

        return $this->_user;
    }
}
