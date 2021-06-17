<?php

namespace Addons\Cms\Models;

use DuAdmin\Helpers\AppHelper;
use Yii;

/**
 * "{{%friend_link}}"表的模型类.
 *
 * @property int $id
 * @property string $name 名称
 * @property int $pid PID
 * @property string $url 网页地址
 * @property int $sort 排序
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 */
class FriendLink extends \DuAdmin\Core\BaseModel
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
        return '{{%friend_link}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'sort'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['url'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('da_friend_link', 'ID'),
            'name' => Yii::t('da_friend_link', 'Name'),
            'pid' => Yii::t('da_friend_link', 'Pid'),
            'url' => Yii::t('da_friend_link', 'Url'),
            'sort' => Yii::t('da_friend_link', 'Sort'),
            'createdAt' => Yii::t('da_friend_link', 'Created At'),
            'updatedAt' => Yii::t('da_friend_link', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return FriendLinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FriendLinkQuery(get_called_class());
    }

    public static function getMapWidthDep()
    {
        return AppHelper::dbQueryAsMapLikeTree(
            self::tableName(),
            'name',
            null,
            'id',
            'pid',
            0,
            1,
            'da_friend_link'
        );
    }
}