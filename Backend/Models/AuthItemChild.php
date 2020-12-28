<?php

namespace Backend\Models;

use Yii;
/**
 * "{{%auth_item_child}}"表的模型类.
 *
 * @property string $parent 上级
 * @property string $child 下级
 * @property int $sort 排序
 *
 * @property AuthItem $child0
 * @property AuthItem $parent0
 */
class AuthItemChild extends \DuAdmin\Core\BaseModel
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
        return '{{%auth_item_child}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['sort'], 'integer'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent', 'child'], 'unique', 'targetAttribute' => ['parent', 'child']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::class, 'targetAttribute' => ['child' => 'id']],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::class, 'targetAttribute' => ['parent' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'parent' => Yii::t('app_auth_item_child', 'Parent'),
            'child' => Yii::t('app_auth_item_child', 'Child'),
            'sort' => Yii::t('app_auth_item_child', 'Sort'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(AuthItem::class, ['id' => 'child']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(AuthItem::class, ['id' => 'parent']);
    }

    /**
     * {@inheritdoc}
     * @return AuthItemChildQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthItemChildQuery(get_called_class());
    }
}
