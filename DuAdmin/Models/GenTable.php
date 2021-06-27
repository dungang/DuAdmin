<?php

namespace DuAdmin\Models;

use Yii;
/**
 * "{{%gen_table}}"表的模型类.
 *
 * @property int $id
 * @property string $tableName 表名
 * @property string $tableComment 表注释
 * @property string $modelNamespace 模型命名空间
 * @property string $modelName 模型名称
 * @property string $modelBaseName 模型基类
 * @property string $activeQueryBaseName 查询模型基类
 * @property string $dbConnectionId 数据库链接ID
 * @property int $enableSearchModel 是否生成搜索模型::0:否|1:是
 * @property int $enableI18n 是否支持国际化::0:否|1:是
 * @property string $backendControllerNamespace 后台控制器命名空间
 * @property string $frontendControllerNamespace 前台控制器命名空间
 * @property string $apiControllerNamespace API控制器命名空间
 * @property string $backendControllerBase 后台控制器基类
 * @property string $frontendControllerBase 前台控制器基类
 * @property string $apiControllerBase API控制器基类
 * @property string $controllerName 控制器名称
 * @property string $backendViewPath 后台控制器视图路径
 * @property string $frontendViewPath 前台控制器视图路径
 * @property string $backendListView 后台控制器列表小部件
 * @property string $frontendistView 前台控制器列表小部件
 * @property string $backendActions 后台控制器的行为清单
 * @property string $frontendActions 前台控制器的行为清单
 * @property string $modalDailogSize 模态框大小::def:默认窗口|sm:小窗口|lg:大窗口
 * @property int $enableUserData 当前用户的数据::0:否|1:是
 * @property int $enablePjax 是否使用Pjax::0:否|1:是
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 */
class GenTable extends \DuAdmin\Core\BaseModel
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
        return '{{%gen_table}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enableSearchModel', 'enableI18n', 'enableUserData', 'enablePjax'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['tableName', 'tableComment', 'modelNamespace', 'modelName', 'modelBaseName', 'activeQueryBaseName', 'dbConnectionId', 'backendControllerNamespace', 'frontendControllerNamespace', 'apiControllerNamespace', 'backendControllerBase', 'frontendControllerBase', 'apiControllerBase', 'controllerName', 'backendViewPath', 'frontendViewPath', 'backendListView', 'frontendistView', 'backendActions', 'frontendActions'], 'string', 'max' => 128],
            [['modalDailogSize'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app_gen_table', 'ID'),
            'tableName' => Yii::t('app_gen_table', 'Table Name'),
            'tableComment' => Yii::t('app_gen_table', 'Table Comment'),
            'modelNamespace' => Yii::t('app_gen_table', 'Model Namespace'),
            'modelName' => Yii::t('app_gen_table', 'Model Name'),
            'modelBaseName' => Yii::t('app_gen_table', 'Model Base Name'),
            'activeQueryBaseName' => Yii::t('app_gen_table', 'Active Query Base Name'),
            'dbConnectionId' => Yii::t('app_gen_table', 'Db Connection ID'),
            'enableSearchModel' => Yii::t('app_gen_table', 'Enable Search Model'),
            'enableI18n' => Yii::t('app_gen_table', 'Enable I18n'),
            'backendControllerNamespace' => Yii::t('app_gen_table', 'Backend Controller Namespace'),
            'frontendControllerNamespace' => Yii::t('app_gen_table', 'Frontend Controller Namespace'),
            'apiControllerNamespace' => Yii::t('app_gen_table', 'Api Controller Namespace'),
            'backendControllerBase' => Yii::t('app_gen_table', 'Backend Controller Base'),
            'frontendControllerBase' => Yii::t('app_gen_table', 'Frontend Controller Base'),
            'apiControllerBase' => Yii::t('app_gen_table', 'Api Controller Base'),
            'controllerName' => Yii::t('app_gen_table', 'Controller Name'),
            'backendViewPath' => Yii::t('app_gen_table', 'Backend View Path'),
            'frontendViewPath' => Yii::t('app_gen_table', 'Frontend View Path'),
            'backendListView' => Yii::t('app_gen_table', 'Backend List View'),
            'frontendistView' => Yii::t('app_gen_table', 'Frontendist View'),
            'backendActions' => Yii::t('app_gen_table', 'Backend Actions'),
            'frontendActions' => Yii::t('app_gen_table', 'Frontend Actions'),
            'modalDailogSize' => Yii::t('app_gen_table', 'Modal Dailog Size'),
            'enableUserData' => Yii::t('app_gen_table', 'Enable User Data'),
            'enablePjax' => Yii::t('app_gen_table', 'Enable Pjax'),
            'createdAt' => Yii::t('app_gen_table', 'Created At'),
            'updatedAt' => Yii::t('app_gen_table', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'enableSearchModel' => '0:否|1:是',
            'enableI18n' => '0:否|1:是',
            'modalDailogSize' => 'def:默认窗口|sm:小窗口|lg:大窗口',
            'enableUserData' => '0:否|1:是',
            'enablePjax' => '0:否|1:是',
        ];
    }

    /**
     * {@inheritdoc}
     * @return GenTableQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GenTableQuery(get_called_class());
    }
}
