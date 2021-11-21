<?php

namespace DuAdmin\Models;

use Yii;
/**
 * "{{%dashboard_widget}}"表的模型类.
 *
 * @property int $id
 * @property string $name 名称
 * @property string $widget 小部件
 * @property string $args 参数
 * @property string $argsInfo 参数说明
 * @property int $status 状态
 * @property int $sort 排序
 * @property string $type 类型
 */
class DashboardWidget extends \DuAdmin\Core\BaseModel
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
        return '{{%dashboard_widget}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'widget'], 'required'],
            [['status', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['widget', 'args'], 'string', 'max' => 128],
            [['argsInfo'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app_dashboard_widget', 'ID'),
            'name' => Yii::t('app_dashboard_widget', 'Name'),
            'widget' => Yii::t('app_dashboard_widget', 'Widget'),
            'args' => Yii::t('app_dashboard_widget', 'Args'),
            'argsInfo' => Yii::t('app_dashboard_widget', 'Args Info'),
            'status' => Yii::t('app_dashboard_widget', 'Status'),
            'sort' => Yii::t('app_dashboard_widget', 'Sort'),
            'type' => Yii::t('app_dashboard_widget', 'Type'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return DashboardWidgetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DashboardWidgetQuery(get_called_class());
    }

    ///**
    // * 默认开启所有操作的事务
    // * ```php
    // * return [
    // *     'admin' => self::OP_INSERT,
    // *     'api' => self::OP_INSERT | self::OP_UPDATE | self::OP_DELETE,
    // *     // the above is equivalent to the following:
    // *     // 'api' => self::OP_ALL,
    // *
    // * ];
    // * ```
    // */
    //public function transactions()
    //{
    //    return [
    //        self::SCENARIO_DEFAULT => self::OP_ALL
    //    ];
    //}
}
