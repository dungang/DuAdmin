<?php
namespace app\backend\forms;

use app\kit\models\User;
use app\kit\core\BaseDynamicModel;
use app\kit\models\UserExtValue;
use app\kit\models\UserExtProperty;

/**
 *
 * @author dungang
 */
class DynamicUser extends BaseDynamicModel
{

    public $id;

    /**
     *
     * @var \app\kit\models\User
     */
    public $model;

    public function init()
    {
        parent::init();
        if (! $this->model) {
            $this->model = new User([
                'scenario' => $this->scenario
            ]);
        }
        $this->model->attachBehavior('role-update','app\kit\behaviors\UpdateUserRoleBehavior');
    }

    public function setScenario($value)
    {
        parent::setScenario($value);
        if ($this->model) {
            $this->model->setScenario($value);
        }
    }

    public static function primaryKey()
    {
        return [
            'id'
        ];
    }

    public function getPrimaryKey()
    {
        return 'id';
    }

    public function getFirstErrors()
    {
        return $this->model->getFirstErrors();
    }

    public function getErrors($attribute = null)
    {
        return $this->model->getErrors($attribute);
    }

    public function scenarios()
    {
        return array(
            $this->scenario => parent::scenarios()['default']
        );
    }

    public function formName()
    {
        return $this->model->formName();
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        if (($rst = $this->model->validate($attributeNames, $clearErrors))) {
            $rst = parent::validate($attributeNames, $clearErrors);
        }
        return $rst;
    }

    public static function findOne($condition)
    {
        if (($user = User::findOne($condition))) {
            if ($user->id) {
                $dynamic = new DynamicUser([],[
                    'id'=>$user->id,
                    'model'=>$user,
                ]);
                $dynamic->prepareExtPropertyValues($user);
                return $dynamic;
            }
        }
        return null;
    }

    public function save($validate = true, $attributeNames = null)
    {
        if ($this->model->save($validate, $attributeNames)) {
            $this->syncRoleAssignment();
            $this->id = $this->model->id;
            $this->saveExtProperites($this);
            return true;
        }
        return false;
    }

    /**
     * 同步用户角色授权
     *
     * @return void
     */
    protected function syncRoleAssignment() {
        if($role = \Yii::$app->authManager->getRole($this->model->role)){
            if(!\Yii::$app->authManager->getAssignment($this->model->role,$this->model->id)) {
                \Yii::$app->authManager->assign($role,$this->model->id);
                \Yii::$app->cache->delete('rbac');
            }
        }
        if(($old_role_name = $this->model->getOldAttribute('role')) != $this->model->role){
            if($old_role = \Yii::$app->authManager->getRole($old_role_name)){
                \Yii::$app->authManager->revoke($old_role,$this->model->id);
                \Yii::$app->cache->delete('rbac');
            }
        }
    }

    public function load($data, $formName = null)
    {
        $rst = $this->model->load($data, $formName);
        if ($rst) {
            $attrs = $this->model->scenarios()[$this->scenario];
            $formName = $this->formName();
            $data[$formName] = array_filter(\array_keys($data[$formName]), function ($key) use ($attrs) {
                return in_array($key, $attrs) ? false : true;
            });
        }
        return $rst;
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\kit\core\BaseDynamicModel::prepareDynmicProperties()
     */
    protected function prepareDynmicProperties()
    {
        return UserExtProperty::find()->all();
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\kit\core\BaseDynamicModel::prepareExtPropertyValueTable()
     */
    protected function prepareExtPropertyValueTable()
    {
        return UserExtValue::tableName();
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\kit\core\BaseDynamicModel::prepareExtPropertyValueRow()
     */
    protected function prepareExtPropertyValueRow($masterModel, $propertyModel)
    {
        return [
            $masterModel->id,
            $propertyModel->field,
            $masterModel->{$propertyModel->field}
        ];
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\kit\core\BaseDynamicModel::prepareExtPropertyValues()
     */
    protected function prepareExtPropertyValues($model)
    {
        if (($values = UserExtValue::findAll([
            'user_id' => $model->id
        ]))) {
            foreach ($values as $value) {
                $this->{$value->field} = $value->value;
            }
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\kit\core\BaseDynamicModel::prepareRulesAndLabelsAndHints()
     */
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

    /**
     *
     * {@inheritdoc}
     * @see \app\kit\core\BaseDynamicModel::prepareExtPropertyValueFields()
     */
    protected function prepareExtPropertyValueFields()
    {
        return [
            'user_id',
            'field',
            'value'
        ];
    }
}

