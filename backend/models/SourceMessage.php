<?php

namespace app\backend\models;

use Yii;

/**
 * "bai_source_message"表的模型类.
 *
 * @property int $id
 * @property string $category
 * @property string $message
 *
 * @property Message[] $messages
 */
class SourceMessage extends \app\kit\core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bai_source_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category'),
            'message' => Yii::t('app', 'Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SourceMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SourceMessageQuery(get_called_class());
    }
}