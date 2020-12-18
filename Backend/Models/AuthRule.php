<?php

namespace Backend\Models;

use Yii;
/**
 * "{{%auth_rule}}"表的模型类.
 *
 * @property string $id ID
 * @property string $name 描述
 * @property resource $data 数据
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 *
 * @property AuthItem[] $authItems
 */
class AuthRule extends \DuAdmin\Core\BaseModel
{
    ///**
    // * 对象json序列化的时候设置不显示的字段
    // *
    // * @var array
    // */
    // public $jsonHideFields = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%auth_rule}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['data'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['id', 'name'], 'string', 'max' => 64],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'name' => Yii::t('backend', 'Name'),
            'data' => Yii::t('backend', 'Data'),
            'createdAt' => Yii::t('da', 'Created At'),
            'updatedAt' => Yii::t('da', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItems()
    {
        return $this->hasMany(AuthItem::className(), ['ruleId' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AuthRuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthRuleQuery(get_called_class());
    }

    /**
     * 保存规则
     *
     * @param boolean $runValidation
     * @param array $attributeNames
     * @return boolean
     */
    public function save($runValidation = true, $attributeNames = NULL) 
    { 
        if ($runValidation && $this->validate()) { 
            $rule = \Yii::createObject($this->id); 
            $rule->id = $this->id; 
            if ($this->isNewRecord) { 
                return \Yii::$app->authManager->add($rule); 
            } else { 
                return \Yii::$app->authManager->update($this->id, $rule); 
            } 
        } 
        return false; 
    } 
}
