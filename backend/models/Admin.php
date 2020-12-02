<?php

namespace app\backend\models;

use app\mmadmin\core\Authable;
use Yii;
use yii\web\IdentityInterface;
use app\mmadmin\core\BaseModel;
use yii\base\NotSupportedException;
use app\mmadmin\core\Operator;

/**
 * "{{%admin}}"表的模型类.
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
 * @property  int $is_super 超管
 * @property int $login_failure 登录失败次数
 * @property int $login_at 登录时间
 * @property string $login_ip 登录IP
 * @property int $created_at 添加时间
 * @property int $updated_at 更新时间
 * @property int $is_del
 */
class Admin extends BaseModel implements IdentityInterface,Authable,Operator
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
        return '{{%admin}}';
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'username' => Yii::t('backend', 'Username'),
            'nickname' => Yii::t('backend', 'Nick Name'),
            'avatar' => Yii::t('backend', 'Avatar'),
            'auth_key' => Yii::t('backend', 'Auth Key'),
            'password' => Yii::t('backend', 'Password'),
            'password_hash' => Yii::t('backend', 'Password Hash'),
            'password_reset_token' => Yii::t('backend', 'Password Reset Token'),
            'email' => Yii::t('backend', 'Email'),
            'mobile' => Yii::t('backend', 'Mobile'),
            'status' => Yii::t('backend', 'Status'),
            'login_failure' => Yii::t('backend', 'Login Failure'),
            'login_at' => Yii::t('backend', 'Login Time'),
            'login_ip' => Yii::t('backend', 'Login Ip'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
            'is_del' => Yii::t('backend', 'Is Del'),
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
                    'nickname',
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
                    'password',
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
                'string',
                'max' => 128
            ]
        ];
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

    // Override this method
    protected static function getSecretKey()
    {
        return Yii::$app->request->cookieValidationKey;
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
        if (!static::isPasswordResetTokenValid($token)) {
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
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
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
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $password = trim($password);
        if (!empty($password)) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws \yii\base\Exception
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
     * get User by access token
     * @param mixed $token
     * @param null $type
     * @return null|void|IdentityInterface
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('Method not support');
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_super == 1;
    }


    public function isActiveAccount(): bool
    {
        return $this->status == static::STATUS_ACTIVE;
    }
    
    /**
     * {@inheritDoc}
     * @see \app\mmadmin\core\Operator::getOperatorId()
     */
    public function getOperatorId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritDoc}
     * @see \app\mmadmin\core\Operator::getOperatorName()
     */
    public function getOperatorName()
    {
       return $this->nickname;
    }
}
