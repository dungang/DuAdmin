<?php
namespace app\kit\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use app\kit\core\BaseModel;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $nick_name
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $mobile
 * @property string $auth_key
 * @property integer $status
 * @property int $is_admin
 * @property int $is_super
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $role
 */
class User extends BaseModel implements IdentityInterface
{

    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 10;

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gt_user';
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
            'status' => '状态',
            'is_admin' => '是超管',
            'email' => '邮箱',
            'mobile' => '手机',
            'is_admin' => '管理者',
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
                    'email'
                ],
                'required'
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

    /**
     *
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
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
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
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
