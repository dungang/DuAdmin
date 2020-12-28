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
            'id' => Yii::t('app_auth_rule', 'ID'),
            'name' => Yii::t('app_auth_rule', 'Name'),
            'data' => Yii::t('app_auth_rule', 'Data'),
            'createdAt' => Yii::t('app_auth_rule', 'Created At'),
            'updatedAt' => Yii::t('app_auth_rule', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItems()
    {
        return $this->hasMany(AuthItem::class, ['ruleId' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AuthRuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthRuleQuery(get_called_class());
    }
}
