<?php
namespace app\backend\forms;

use yii\web\NotFoundHttpException;
use app\kit\models\User;
use app\kit\behaviors\UploadedFileBehavior;
use yii\helpers\Json;
use app\kit\models\UserExtProperty;
use app\kit\models\UserExtValue;
use app\kit\core\BaseDynamicModel;

/**
 * 添加修改用户的表单
 *
 * @author dungang
 */
class UserForm extends BaseDynamicModel
{

    public $id;

    public $username;

    public $nick_name;

    public $avatar;

    public $password;

    public $email;

    public $mobile;

    public $dingding;

    public $wechat;

    public $qq;

    public $wangwang;

    public $tel;

    public $status;

    public $role;

    public $crop;

    public function rules()
    {
        $rules = parent::rules();

        $rules[] = [
            [
                'username',
                'nick_name',
                'email',
                'mobile'
            ],
            'required'
        ];
        $rules[] = [
            [
                'password',
                'role',
                'wechat',
                'qq',
                'dingding',
                'wangwang',
                'tel',
                'crop'
            ],
            'safe'
        ];
        $rules[] = [
            'status',
            'default',
            'value' => User::STATUS_ACTIVE
        ];
        $rules[] = [
            'status',
            'in',
            'range' => [
                User::STATUS_ACTIVE,
                User::STATUS_DELETED
            ]
        ];
        $rules[] = [
            [
                'avatar'
            ],
            'file',
            'skipOnEmpty' => true,
            'extensions' => 'png,jpg'
        ];
        return $rules;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return \array_merge(parent::attributeLabels(),
            [
                'id' => 'ID',
                'username' => '账号',
                'nick_name' => '姓名',
                'avatar' => '头像',
                'status' => '状态',
                'email' => '邮箱',
                'mobile' => '手机',
                'wechat' => '微信',
                'tel' => '固话',
                'qq' => 'QQ',
                'dingding' => '钉钉',
                'wangwang' => '旺旺',
                'role' => '角色',
                'password' => '密码'
            ]);
    }

    /**
     * 加载用户模型的数据
     *
     * @param User $model
     */
    public function loadUser($model)
    {
        $this->id = $model->id;
        $this->username = $model->username;
        $this->nick_name = $model->nick_name;
        $this->email = $model->email;
        $this->mobile = $model->mobile;
        $this->status = $model->status;
        $this->role = $model->role;
        $this->avatar = $model->avatar;
        if ($model->id) {
            $this->prepareExtPropertyValues($model);
        }
    }

    /**
     * 保存
     *
     * @return boolean
     */
    public function save($validate = true)
    {
        if ($validate && ! $this->validate()) {
            return false;
        }
        $user = new User();
        $user->id = $this->id;
        if ($user->id) {
            if (! $user = User::findOne([
                'id' => $user->id
            ])) {
                throw new NotFoundHttpException("用户不存在");
            }
        } else {
            $user->generateAuthKey();
        }
        $user->username = $this->username;
        $user->nick_name = $this->nick_name;
        $user->status = $this->status;
        $user->email = $this->email;
        if ($this->avatar) {
            $user->avatar = $this->avatar;
        }
        $user->mobile = $this->mobile;
        $user->role = $this->role;
        if ($this->password) {
            $user->setPassword($this->password);
        }
        if ($user->save(false)) {
            $this->id = $user->id;
            $this->saveExtProperites($this);
            return true;
        } else {
            return false;
        }
    }

    public function behaviors()
    {
        $bs = parent::behaviors();
        $bs['uploaded_file'] = [
            'class' => UploadedFileBehavior::className(),
            'initFieldsCallback' => function ($behavior) {
                $crop = Json::decode($behavior->owner->crop);
                if ($crop) {
                    $this->fields = [
                        'avatar' => [
                            'file_path' => 'uploads/avatar/' . \Yii::$app->user->id . '.png',
                            'width' => $crop['w'],
                            'height' => $crop['h'],
                            'x' => $crop['x'],
                            'y' => $crop['y'],
                            'mode' => 'inset'
                        ]
                    ];
                }
            }
        ];
        return $bs;
    }

    protected function prepareDynmicProperties()
    {
        return UserExtProperty::find()->all();
    }

    protected function prepareExtPropertyValueTable()
    {
        return UserExtValue::tableName();
    }

    protected function prepareExtPropertyValueRow($masterModel, $propertyModel)
    {
        return [
            $masterModel->id,
            $propertyModel->field,
            $this->{$propertyModel->field}
        ];
    }

    protected function prepareExtPropertyValues($model)
    {
        if ($values = UserExtValue::findAll([
            'user_id' => $model->id
        ])) {
            foreach ($values as $value) {
                $this->{$value->field} = $value->value;
            }
        }
    }

    protected function prepareRulesAndLabelsAndHints()
    {
        foreach ($this->getDynamicProperties() as $property) {
            $this->defineAttribute($property->field);
            $rule = [
                $property->field,
                $property->data_type
            ];
            if ($property->data_length) {
                $rule['max'] = $property->data_length;
            }
            $this->addDynamicRule($rule);
            $this->addDynamicLabel($property->field, $property->name);
        }
    }

    protected function prepareExtPropertyValueFields()
    {
        return [
            'user_id',
            'field',
            'value'
        ];
    }
}

