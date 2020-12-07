<?php

namespace Frontend\Models;

use DuAdmin\Core\Authable;
use Yii;
use yii\web\IdentityInterface;
use DuAdmin\Core\BaseModel;
use yii\base\NotSupportedException;
use DuAdmin\Core\Operator;

/**
 * "{{%user}}"表的模型类.
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $nickname 昵称
 * @property string $avatar 头像
 * @property string $authKey 授权KEY
 * @property string $passwordHash 密码hash
 * @property string $passwordResetToken 密码重置token
 * @property string $email 邮箱
 * @property string $mobile 手机
 * @property int $status 状态
 * @property int $isSuper 是否超管
 * @property string $loginAt 上次登陆时间
 * @property string $loginFailure 登陆失败消息
 * @property string $loginIp 登录IP
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 * @property int $isDel
 */
class User extends BaseModel implements IdentityInterface,Authable,Operator
{

    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 10;

    public $password;
    
    public $jsonHideFields = ['authKey','passwordHash','passwordResetToken'];

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
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'nickname' => Yii::t('app', 'Nickname'),
            'avatar' => Yii::t('app', 'Avatar'),
            'authKey' => Yii::t('app', 'Auth Key'),
            'passwordHash' => Yii::t('app', 'Password Hash'),
            'passwordResetToken' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'mobile' => Yii::t('app', 'Mobile'),
            'status' => Yii::t('app', 'Status'),
            'isSuper' => Yii::t('app', 'Is Super'),
            'loginAt' => Yii::t('app', 'Login At'),
            'loginFailure' => Yii::t('app', 'Login Failure'),
            'loginIp' => Yii::t('app', 'Login Ip'),
            'createdAt' => Yii::t('da', 'Created At'),
            'updatedAt' => Yii::t('da', 'Updated At'),
            'isDel' => Yii::t('da', 'Is Del')
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
            'passwordResetToken' => $token,
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
        return $this->authKey;
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
        return Yii::$app->security->validatePassword($password, $this->passwordHash);
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
            $this->passwordHash = Yii::$app->security->generatePasswordHash($password);
        }
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->passwordResetToken = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->passwordResetToken = null;
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
        return $this->isSuper == 1;
    }


    public function isActiveAccount(): bool
    {
        return $this->status == static::STATUS_ACTIVE;
    }
    
    /**
     * {@inheritDoc}
     * @see \DuAdmin\Core\Operator::getOperatorId()
     */
    public function getOperatorId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritDoc}
     * @see \DuAdmin\Core\Operator::getOperatorName()
     */
    public function getOperatorName()
    {
       return $this->nickname;
    }
}
