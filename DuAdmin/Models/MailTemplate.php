<?php

namespace DuAdmin\Models;

use Yii;
/**
 * "{{%mail_template}}"表的模型类.
 *
 * @property int $id
 * @property string $code 业务编码::建议以应标识为前缀避免碰撞
 * @property string $title 邮件名称
 * @property string $content 邮件内容
 * @property string $varsInfo 变量说明
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 */
class MailTemplate extends \DuAdmin\Core\BaseModel
{
    ///**
    // * 对象json序列化的时候设置不显示的字段
    // *
    // * @var array
    // */
    // public $jsonHideFields = [];

    // /**
    //  * 存储的数据是json的字段
    //  *
    //  * @var array
    //  */
    // public $jsonFields = [];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mail_template}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'title'], 'required'],
            [['content'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['code'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 128],
            [['varsInfo'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app_mail_template', 'ID'),
            'code' => Yii::t('app_mail_template', 'Code'),
            'title' => Yii::t('app_mail_template', 'Title'),
            'content' => Yii::t('app_mail_template', 'Content'),
            'varsInfo' => Yii::t('app_mail_template', 'Vars Info'),
            'createdAt' => Yii::t('app_mail_template', 'Created At'),
            'updatedAt' => Yii::t('app_mail_template', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'code' => '建议以应标识为前缀避免碰撞',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MailTemplateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MailTemplateQuery(get_called_class());
    }
}
