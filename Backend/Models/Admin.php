<?php

namespace Backend\Models;

use DuAdmin\Behaviors\PasswordBehavior;
use DuAdmin\Core\Authable;
use DuAdmin\Core\BaseModel;
use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * "{{%admin}}"表的模型类.
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
 *
 * @property AuthRole[] $roles
 *
 * @property AuthAssignment[] $assignments
 */
class Admin extends BaseModel implements IdentityInterface, Authable {

  const STATUS_INACTIVE = 0;

  const STATUS_ACTIVE = 10;

  public $password;

  /**
   *
   * {@inheritdoc}
   */
  public static function tableName() {

    return '{{%admin}}';

  }

  public function init() {

    parent::init();
    // json 隐藏字段
    $this->jsonHideFields = [
        'password',
        'passwordHash',
        'authKey',
        'passwordResetToken'
    ];

  }

  public function behaviors() {

    $bs = parent::behaviors();
    $bs ['password-set'] = PasswordBehavior::class;
    return $bs;

  }

  /**
   *
   * {@inheritdoc}
   */
  public function attributeLabels() {

    return [
        'id' => Yii::t( 'app_admin', 'ID' ),
        'username' => Yii::t( 'app_admin', 'Username' ),
        'nickname' => Yii::t( 'app_admin', 'Nickname' ),
        'avatar' => Yii::t( 'app_admin', 'Avatar' ),
        'authKey' => Yii::t( 'app_admin', 'Auth Key' ),
        'password' => Yii::t( 'app_admin', 'Password' ),
        'passwordHash' => Yii::t( 'app_admin', 'Password Hash' ),
        'passwordResetToken' => Yii::t( 'app_admin', 'Password Reset Token' ),
        'email' => Yii::t( 'app_admin', 'Email' ),
        'mobile' => Yii::t( 'app_admin', 'Mobile' ),
        'status' => Yii::t( 'app_admin', 'Status' ),
        'isSuper' => Yii::t( 'app_admin', 'Is Super' ),
        'loginAt' => Yii::t( 'app_admin', 'Login At' ),
        'loginFailure' => Yii::t( 'app_admin', 'Login Failure' ),
        'loginIp' => Yii::t( 'app_admin', 'Login Ip' ),
        'createdAt' => Yii::t( 'app_admin', 'Created At' ),
        'updatedAt' => Yii::t( 'app_admin', 'Updated At' ),
        'isDel' => Yii::t( 'app_admin', 'Is Del' )
    ];

  }

  /**
   *
   * {@inheritdoc}
   */
  public function rules() {

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
                'email',
                'mobile'
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
                self::STATUS_INACTIVE
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
  public static function findIdentity($id) {

    return static::findOne( [
        'id' => $id,
        'status' => self::STATUS_ACTIVE
    ] );

  }

  // Override this method
  protected static function getSecretKey() {

    return Yii::$app->request->cookieValidationKey;

  }

  // And this one if you wish
  protected static function getHeaderToken() {

    return [ ];

  }

  /**
   * Finds user by username
   *
   * @param string $username
   * @return static|null
   */
  public static function findByUsername($username) {

    return static::findOne( [
        'username' => $username,
        'status' => self::STATUS_ACTIVE
    ] );

  }

  /**
   * Finds user by password reset token
   *
   * @param string $token
   *          password reset token
   * @return static|null
   */
  public static function findByPasswordResetToken($token) {

    if (! static::isPasswordResetTokenValid( $token )) {
      return null;
    }
    return static::findOne( [
        'passwordResetToken' => $token,
        'status' => self::STATUS_ACTIVE
    ] );

  }

  /**
   * Finds out if password reset token is valid
   *
   * @param string $token
   *          password reset token
   * @return bool
   */
  public static function isPasswordResetTokenValid($token) {

    if (empty( $token )) {
      return false;
    }
    $timestamp = ( int ) substr( $token, strrpos( $token, '_' ) + 1 );
    $expire = Yii::$app->params ['user.passwordResetTokenExpire'];
    return $timestamp + $expire >= time();

  }

  /**
   *
   * {@inheritdoc}
   */
  public function getId() {

    return $this->getPrimaryKey();

  }

  /**
   *
   * {@inheritdoc}
   */
  public function getAuthKey() {

    return $this->authKey;

  }

  /**
   *
   * {@inheritdoc}
   */
  public function validateAuthKey($authKey) {

    return $this->getAuthKey() === $authKey;

  }

  public function getPassword() {

    return null;

  }

  /**
   * Validates password
   *
   * @param string $password
   *          password to validate
   * @return bool if password provided is valid for current user
   */
  public function validatePassword($password) {

    return Yii::$app->security->validatePassword( $password, $this->passwordHash );

  }

  /**
   * Generates password hash from password and sets it to the model
   *
   * @param
   *          $password
   * @throws \yii\base\Exception
   */
  public function setPassword($password) {

    $password = trim( $password );
    if (! empty( $password )) {
      $this->passwordHash = Yii::$app->security->generatePasswordHash( $password );
    }

  }

  /**
   * Generates "remember me" authentication key
   *
   * @throws \yii\base\Exception
   */
  public function generateAuthKey() {

    $this->authKey = Yii::$app->security->generateRandomString();

  }

  /**
   * Generates new password reset token
   *
   * @throws \yii\base\Exception
   */
  public function generatePasswordResetToken() {

    $this->passwordResetToken = Yii::$app->security->generateRandomString() . '_' . time();

  }

  /**
   * Removes password reset token
   */
  public function removePasswordResetToken() {

    $this->passwordResetToken = null;

  }

  /**
   * get User by access token
   *
   * @param mixed $token
   * @param null $type
   * @return null|void|IdentityInterface
   * @throws NotSupportedException
   */
  public static function findIdentityByAccessToken($token, $type = null) {

    throw new NotSupportedException( 'Method not support' );

  }

  public function isSuperAdmin(): bool {

    return $this->isSuper == 1;

  }

  public function isActiveAccount(): bool {

    return $this->status == static::STATUS_ACTIVE;

  }

  public function getRoles() {

    return $this->hasMany( AuthRole::class, [
        'id' => 'itemId'
    ] )->via( 'assignments' );

  }

  public function getRolesText() {

    return implode( ',', array_map( function ($role) {
      return $role->description;
    }, $this->roles ) );

  }

  public function getAssignments() {

    return $this->hasMany( AuthAssignment::class, [
        'userId' => 'id'
    ] );

  }
}
