<?php

namespace Addons\Cms\Models;

use DuAdmin\Helpers\AppHelper;
use Yii;

/**
 * "{{%cms_friend_link}}"表的模型类.
 *
 * @property int $id
 * @property int $pid PID
 * @property string $name 名称
 * @property string $type 类型::url:链接|email:邮件|tel:电话|qrcode:二维码|label:标签|labelurl:标签链接
 * @property string $pic 图片
 * @property string $url 网页地址
 * @property int $sort 排序
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 */
class FriendLink extends \DuAdmin\Core\BaseModel {
    // /**
    // * 对象json序列化的时候设置不显示的字段
    // *
    // * @var array
    // */
    // public $jsonHideFields = [];

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName() {

        return '{{%cms_friend_link}}';
    }

    /**
     *
     * {@inheritdoc}
     */
    public function rules() {

        return [
            [
                [
                    'pid',
                    'sort'
                ],
                'integer'
            ],
            [
                [ 'pid' ], 'default', 'value' => 0
            ],
            [
                [
                    'createdAt',
                    'updatedAt'
                ],
                'safe'
            ],
            [
                [
                    'name'
                ],
                'string',
                'max' => 64
            ],
            [
                [
                    'type'
                ],
                'string',
                'max' => 16
            ],
            [
                [
                    'pic',
                    'url'
                ],
                'string',
                'max' => 128
            ]
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeLabels() {

        return [
            'id'        => Yii::t( 'da_friend_link', 'ID' ),
            'pid'       => Yii::t( 'da_friend_link', 'Pid' ),
            'name'      => Yii::t( 'da_friend_link', 'Name' ),
            'type'      => Yii::t( 'da_friend_link', 'Type' ),
            'pic'       => Yii::t( 'da_friend_link', 'Pic' ),
            'url'       => Yii::t( 'da_friend_link', 'Url' ),
            'sort'      => Yii::t( 'da_friend_link', 'Sort' ),
            'createdAt' => Yii::t( 'da_friend_link', 'Created At' ),
            'updatedAt' => Yii::t( 'da_friend_link', 'Updated At' )
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeHints() {

        return [
            'type' => 'url:链接|email:邮件|tel:电话|qrcode:二维码|label:标签|labelurl:标签链接'
        ];
    }

    /**
     *
     * {@inheritdoc}
     * @return FriendLinkQuery the active query used by this AR class.
     */
    public static function find() {

        return new FriendLinkQuery( get_called_class() );
    }

    public static function getMapWidthDep() {

        return AppHelper::dbQueryAsMapLikeTree( self::tableName(), 'name', null, 'id', 'pid', 0, 1, 'da_friend_link' );
    }

}
