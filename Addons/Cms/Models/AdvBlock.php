<?php

namespace Addons\Cms\Models;

use Yii;

/**
 * "{{%cms_adv_block}}"表的模型类.
 *
 * @property int $id
 * @property string $name 名称
 * @property string $nameCode 编码
 * @property string $urlPath 页面路径
 * @property string $pic 图片
 * @property string $type 类型::image:图片|js:js代码|html:html代码|google-adv:谷歌广告
 * @property string $url 网络地址
 * @property int $isFlat 是否平铺::1:是|0:否
 * @property string $content 内容
 * @property string $startedAt 开始时间
 * @property string $endAt 结束时间
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 */
class AdvBlock extends \DuAdmin\Core\BaseModel {
    ///**
    // * 对象json序列化的时候设置不显示的字段
    // *
    // * @var array
    // */
    // public $jsonHideFields = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%cms_adv_block}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [ [ 'isFlat' ], 'integer' ],
            [ [ 'content' ], 'string' ],
            [ [ 'startedAt', 'endAt', 'createdAt', 'updatedAt' ], 'safe' ],
            [ [ 'name', 'pic', 'url' ], 'string', 'max' => 128 ],
            [ [ 'nameCode', 'urlPath' ], 'string', 'max' => 64 ],
            [ [ 'type' ], 'string', 'max' => 32 ],
            [ [ 'nameCode', 'urlPath' ], 'unique', 'targetAttribute' => [ 'nameCode', 'urlPath' ] ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id'        => Yii::t( 'da_cms_adv_block', 'ID' ),
            'name'      => Yii::t( 'da_cms_adv_block', 'Name' ),
            'nameCode'  => Yii::t( 'da_cms_adv_block', 'Name Code' ),
            'urlPath'   => Yii::t( 'da_cms_adv_block', 'Url Path' ),
            'pic'       => Yii::t( 'da_cms_adv_block', 'Pic' ),
            'type'      => Yii::t( 'da_cms_adv_block', 'Type' ),
            'url'       => Yii::t( 'da_cms_adv_block', 'Url' ),
            'isFlat'    => Yii::t( 'da_cms_adv_block', 'Is Flat' ),
            'content'   => Yii::t( 'da_cms_adv_block', 'Content' ),
            'startedAt' => Yii::t( 'da_cms_adv_block', 'Started At' ),
            'endAt'     => Yii::t( 'da_cms_adv_block', 'End At' ),
            'createdAt' => Yii::t( 'da_cms_adv_block', 'Created At' ),
            'updatedAt' => Yii::t( 'da_cms_adv_block', 'Updated At' ),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints() {
        return [
            'type'   => 'image:图片|js:js代码|html:html代码|google-adv:谷歌广告',
            'isFlat' => '1:是|0:否',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AdvBlockQuery the active query used by this AR class.
     */
    public static function find() {
        return new AdvBlockQuery( get_called_class() );
    }

}
