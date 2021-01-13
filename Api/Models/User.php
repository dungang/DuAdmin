<?php
namespace Api\Models;

use Yii;
use Addons\User\Hooks\DeleteUserHook;
use Addons\User\Hooks\RegisterUserHook;
use Addons\User\Hooks\UpdateUserHook;
use DuAdmin\Models\JWTUser;
use DuAdmin\Core\Operator;

/**
 * "{{%user}}"表的模型类.
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $nickname 姓名
 * @property string $avatar 头像
 * @property string $auth_key 验证密钥
 * @property string $password_hash 密码hash
 * @property string $password_reset_token 密码重置token
 * @property string $email 邮箱
 * @property string $mobile 手机
 * @property int $status 状态
 * @property int $login_failure 登录失败次数
 * @property int $login_time 登录时间
 * @property string $login_ip 登录IP
 * @property int $created_at 添加时间
 * @property int $updated_at 更新时间
 */
class User extends JWTUser implements Operator
{

    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 10;

    public $password;

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('da', 'ID'),
            'username' => Yii::t('da', 'User Name'),
            'nickname' => Yii::t('da', 'Nick Name'),
            'avatar' => Yii::t('da', 'Avatar'),
            'auth_key' => Yii::t('da', 'Auth Key'),
            'password' => Yii::t('da', 'Password'),
            'password_hash' => Yii::t('da', 'Password Hash'),
            'password_reset_token' => Yii::t('da', 'Password Reset Token'),
            'email' => Yii::t('da', 'Email'),
            'mobile' => Yii::t('da', 'Mobile'),
            'status' => Yii::t('da', 'Status'),
            'login_failure' => Yii::t('da', 'Login Failure'),
            'login_time' => Yii::t('da', 'Login Time'),
            'login_ip' => Yii::t('da', 'Login Ip'),
            'created_at' => Yii::t('da', 'Created At'),
            'updated_at' => Yii::t('da', 'Updated At')
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'username',
                    'nick_name',
                    'email',
                    'mobile'
                ],
                'required'
            ],
            [
                [
                    'username',
                    'email'
                ],
                'unique'
            ],
            [
                [
                    'password'
                ],
                'string'
            ],
            [
                'status',
                'default',
                'value' => self::STATUS_ACTIVE
            ],
            [
                'status',
                'in',
                'range' => [
                    self::STATUS_ACTIVE,
                    self::STATUS_DELETED
                ]
            ],
            [
                [
                    'avatar'
                ],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg'
            ]
        ];
    }

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_AFTER_INSERT, function ($event) {
            RegisterUserHook::emit($this, [
                'user' => $this
            ]);
        });
        $this->on(self::EVENT_AFTER_UPDATE, function ($event) {
            UpdateUserHook::emit($this, [
                'user' => $this
            ]);
        });
        $this->on(self::EVENT_AFTER_DELETE, function ($event) {
            DeleteUserHook::emit($this, [
                'user' => $this
            ]);
        });
    }

    /**
     *
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    // And this one if you wish
    protected static function getHeaderToken()
    {
        return [];
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne([
            'username' => $username,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token
     *            password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (! static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token
     *            password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getPassword()
    {
        return null;
    }

    /**
     * Validates password
     *
     * @param string $password
     *            password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $password = trim($password);
        if (! empty($password)) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     *
     * {@inheritdoc}
     * @see \DuAdmin\Core\Operator::getOperatorId()
     */
    public function getOperatorId()
    {
        return $this->id;
    }

    /**
     *
     * {@inheritdoc}
     * @see \DuAdmin\Core\Operator::getOperatorName()
     */
    public function getOperatorName()
    {
        return $this->nickname;
    }
}

