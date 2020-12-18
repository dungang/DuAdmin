<?php

namespace Backend\Models;

use Yii;
/**
 * "{{%auth_assignment}}"表的模型类.
 *
 * @property string $itemId 权限
 * @property string $userId 用户ID
 * @property string $createdAt 添加时间
 *
 * @property AuthItem $item
 */
class AuthAssignment extends \DuAdmin\Core\BaseModel
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
        return '{{%auth_assignment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['itemId', 'userId'], 'required'],
            [['createdAt'], 'safe'],
            [['itemId', 'userId'], 'string', 'max' => 64],
            [['itemId', 'userId'], 'unique', 'targetAttribute' => ['itemId', 'userId']],
            [['itemId'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['itemId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'itemId' => Yii::t('backend', 'Item ID'),
            'userId' => Yii::t('backend', 'User ID'),
            'createdAt' => Yii::t('da', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(AuthItem::className(), ['id' => 'itemId']);
    }

    /**
     * {@inheritdoc}
     * @return AuthAssignmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthAssignmentQuery(get_called_class());
    }
}
