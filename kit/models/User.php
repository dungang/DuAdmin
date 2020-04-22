<?php

namespace app\kit\models;

use Yii;
use yii\web\IdentityInterface;
use app\kit\core\BaseModel;
use app\kit\hooks\DeleteUserHook;
use app\kit\hooks\RegisterUserHook;
use app\kit\hooks\UpdateUserHook;
use damirka\JWT\UserTrait;

/**
 * User model
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $nick_name 姓名
 * @property string $avatar 头像
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $email 邮箱
 * @property string $mobile 手机
 * @property string $wechat 微信
 * @property string $tel 固话
 * @property string $qq QQ
 * @property string $dingding 钉钉
 * @property string $wangwang 旺旺
 * @property int $status 状态
 * @property int $is_admin 管理员
 * @property int $is_super 超管
 * @property int $created_at 添加时间
 * @property int $updated_at 更新时间
 * @property string $role 角色
 * @property int $is_del
 * @property string $password_hash
 * @property string $password write-only password
 */
class User extends BaseModel implements IdentityInterface
{

    use UserTrait;

    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 10;

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
            'id' => 'ID',
            'username' => '用户名',
            'nick_name' => '姓名',
            'avatar' => '头像',
            'status' => '状态',
            'is_admin' => '是超管',
            'email' => '邮箱',
            'mobile' => '手机',
            'wechat' => '微信',
            'tel' => '固话',
            'qq' => 'QQ',
            'dingding' => '钉钉',
            'wangwang' => '旺旺',
            'is_admin' => '后台用户',
            'is_super' => '超管',
            'password' => '密码',
            'role' => '角色',
            'created_at' => '添加时间',
            'updated_at' => '更新时间'
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
                    'password',
                    'role',
                    'wechat',
                    'qq',
                    'dingding',
                    'wangwang',
                    'tel'
                ],
                'string'
            ],
            [
                [
                    'is_admin',
                    //'is_super'
                ],
                'boolean',
                'on' => 'manage'
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
            RegisterUserHook::emit(['user' => $this]);
        });
        $this->on(self::EVENT_AFTER_UPDATE, function ($event) {
            UpdateUserHook::emit(['user' => $this]);
        });
        $this->on(self::EVENT_AFTER_DELETE, function ($event) {
            DeleteUserHook::emit(['user' => $this]);
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
        if (!empty($password)) {
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
}
