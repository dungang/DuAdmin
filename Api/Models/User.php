<?php

namespace Api\Models;

use DuAdmin\Hooks\UserCreatedHook;
use DuAdmin\Models\JWTUser;
use Yii;

/**
 * "{{%user}}"表的模型类.
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $nickname 姓名
 * @property string $avatar 头像
 * @property string $authKey 验证密钥
 * @property string $passwordHash 密码hash
 * @property string $passwordRestToken 密码重置token
 * @property string $verificationToken 邮件验证token
 * @property string $email 邮箱
 * @property string $mobile 手机
 * @property int $status 状态
 * @property int $loginFailure 登录失败次数
 * @property int $loginTime 登录时间
 * @property string $loginIp 登录IP
 * @property int $created_at 添加时间
 * @property int $updated_at 更新时间
 */
class User extends JWTUser
{

  const STATUS_DELETED = 0;

  const STATUS_ACTIVE = 10;

  public $password;

  public $jsonHideFields = [
    'password',
    'passwordHash',
    'passwordResetToken',
    'verificationToken',
    'authKey'
  ];

  /**
   *
   * {@inheritdoc}
   */
  public static function tableName()
  {

    return '{{%user}}';
  }

  public function init()
  {

    parent::init();
    $this->on(static::EVENT_AFTER_INSERT, function ($event) {
      UserCreatedHook::emit($this);
    });
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
      'gender' => Yii::t('da', 'Gender'),
      'avatar' => Yii::t('da', 'Avatar'),
      'authKey' => Yii::t('da', 'Auth Key'),
      'password' => Yii::t('da', 'Password'),
      'passwordHash' => Yii::t('da', 'Password Hash'),
      'passwordRestToken' => Yii::t('da', 'Password Reset Token'),
      'verificationToken' => Yii::t('da', 'Verification Token'),
      'email' => Yii::t('da', 'Email'),
      'mobile' => Yii::t('da', 'Mobile'),
      'status' => Yii::t('da', 'Status'),
      'loginFailure' => Yii::t('da', 'Login Failure'),
      'loginTime' => Yii::t('da', 'Login Time'),
      'loginIp' => Yii::t('da', 'Login Ip'),
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
          'nickname',
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
      ['gender', 'default', 'value' => 0],
      ['gender', 'in', 'range' => [0, 1, 2]],
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
   *          password reset token
   * @return static|null
   */
  public static function findByPasswordResetToken($token)
  {

    if (!static::isPasswordResetTokenValid($token)) {
      return null;
    }
    return static::findOne([
      'passwordRestToken' => $token,
      'status' => self::STATUS_ACTIVE
    ]);
  }

  /**
   * Finds out if password reset token is valid
   *
   * @param string $token
   *          password reset token
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
   *          password to validate
   * @return bool if password provided is valid for current user
   */
  public function validatePassword($password)
  {

    return Yii::$app->security->validatePassword($password, $this->passwordHash);
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
      $this->passwordHash = Yii::$app->security->generatePasswordHash($password);
    }
  }

  /**
   * Generates "remember me" authentication key
   */
  public function generateAuthKey()
  {

    $this->authKey = Yii::$app->security->generateRandomString();
  }

  /**
   * Generates new password reset token
   */
  public function generatePasswordResetToken()
  {

    $this->passwordRestToken = Yii::$app->security->generateRandomString() . '_' . time();
  }

  /**
   * Generates new token for email verification
   */
  public function generateEmailVerificationToken()
  {
    $this->verificationToken = Yii::$app->security->generateRandomString() . '_' . time();
  }

  /**
   * Removes password reset token
   */
  public function removePasswordResetToken()
  {

    $this->passwordRestToken = null;
  }

  public function generateRandomUserName($prefix = '')
  {
    $this->username = $prefix . date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
  }
}
