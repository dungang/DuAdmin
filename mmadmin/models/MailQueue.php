<?php

namespace app\mmadmin\models;

/**
 * "{{%mail_queue}}"表的模型类.
 *
 * @property int $id
 * @property string $status 状态
 * @property string $sender 发送者
 * @property string $subject 标题
 * @property string $recipient 接收者
 * @property string $content 内容
 * @property string $time_to_send 定时
 * @property int $try_send 重试次数
 * @property bool $del_after_send 发送后删除
 * @property int $sent_at 发送时间
 * @property int $created_at 添加时间
 */
class MailQueue extends \app\mmadmin\core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mail_queue}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'recipient', 'content'], 'string'],
            [['sender', 'subject', 'recipient', 'content'], 'required'],
            [['time_to_send'], 'safe'],
            [['try_send', 'sent_at', 'created_at'], 'integer'],
            [['del_after_send'], 'boolean'],
            [['sender'], 'string', 'max' => 64],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => '状态',
            'sender' => '发送者',
            'subject' => '标题',
            'recipient' => '接收者',
            'content' => '内容',
            'time_to_send' => '定时',
            'try_send' => '重试次数',
            'del_after_send' => '发送后删除',
            'sent_at' => '发送时间',
            'created_at' => '添加时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MailQueueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MailQueueQuery(get_called_class());
    }
}
