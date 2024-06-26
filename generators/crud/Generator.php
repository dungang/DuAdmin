<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\generators\crud;

use app\generators\CodeFile;
use Yii;
use yii\db\Schema;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;

/**
 * Generates CRUD
 *
 * @property array $columnNames Model column names. This property is read-only.
 * @property string $controllerID The controller ID (without the module ID prefix). This property is
 *           read-only.
 * @property string $nameAttribute This property is read-only.
 * @property array $searchAttributes Searchable attributes. This property is read-only.
 * @property bool|\yii\db\TableSchema $tableSchema This property is read-only.
 * @property string $viewPath The controller view path. This property is read-only.
 * @property string $modelClass
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \app\generators\Generator
{

    // 引用的类
    public $useFormClassies = [];

    public $useSearchFormClassies = [];

    /**
     * 模型的命名空间
     *
     * @var string
     */
    public $modelNamespace;

    /**
     * 没有命名空间的模型类名
     *
     * @var string
     */
    public $modelName;

    /**
     * 没有命名空间的控制器类名
     *
     * @var string
     */
    public $controllerName;

    /**
     * 控制器的命名空间
     *
     * @var string
     */
    public $controllerNamespace;

    // public $modelClass;
    // public $controllerClass;
    // public $viewPath;
    /**
     * 视图的base路径
     *
     * @var string
     */
    public $viewPathBase;

    public $baseControllerClass = 'DuAdmin\Core\BackendController';

    public $indexWidgetType = 'grid';

    // public $searchModelClass = '';
    /**
     * 设置是否在控制器上设置只查询当前用户的数据
     *
     * @var boolean
     */
    public $onlyQueryCurrentUser = false;

    public $templates = [
        'backend-controller' => '@app/generators/crud/backend-controller',
        //'backend-actions'    => '@app/generators/crud/backend-actions',
        'frontend'           => '@app/generators/crud/frontend'
    ];

    public $modalSize = 'linkButtonWithSimpleModal';

    /**
     *
     * @var bool whether to wrap the `GridView` or `ListView` widget with the `yii\widgets\Pjax` widget
     * @since 2.0.5
     */
    public $enablePjax = true;

    /**
     * 是否开启默认排序
     *
     * @var boolean
     */
    public $enableDefaultOrder = true;

    /**
     * 默认排序的字段
     *
     * @var string
     */
    public $defaultOrderField = 'createdAt';

    /**
     * 排序的顺序
     *
     * @var string
     */
    public $defaultOrder = 'SORT_DESC';

    /**
     * 是否支持增删改
     *
     * @var string
     */
    public $enableCrudAction = true;

    /**
     * 控制器支持的actions清单
     *
     * @var array
     */
    public $actions = [];

    /**
     *
     * {@inheritdoc}
     */
    public function getName()
    {

        return 'CRUD生成器';

    }

    /**
     *
     * {@inheritdoc}
     */
    public function getDescription()
    {

        return '该生成器将会根据指定的数据模型生成一个控制器和包含CRUD的多个视图（创建，读取，更新，删除）';

    }

    public function getModelClass()
    {

        if ( $this->modelName ) {
            return $this->modelNamespace . '\\' . $this->modelName;
        }
        return null;

    }

    public function getSearchModelClass()
    {

        if ( $this->modelName ) {
            return $this->modelNamespace . '\\' . $this->modelName . 'Search';
        }
        return null;

    }

    public function getControllerClass()
    {

        if ( $this->controllerName ) {
            return $this->controllerNamespace . '\\' . $this->controllerName;
        }
        return null;

    }

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {

        return array_merge( parent::rules(), [
            [
                [
                    'modelNamespace',
                    'modelName',
                    'controllerNamespace',
                    'controllerName',
                    'viewPathBase',
                    'baseControllerClass'
                ],
                'filter',
                'filter' => 'trim'
            ],
            [
                [
                    'modelNamespace',
                    'modelName',
                    'controllerNamespace',
                    'controllerName',
                    'baseControllerClass',
                    'viewPathBase',
                    'indexWidgetType',
                    'actions'
                ],
                'required'
            ],
            [
                [
                    'modelNamespace',
                    'modelName',
                    'controllerNamespace',
                    'controllerName',
                    'baseControllerClass'
                ],
                'match',
                'pattern' => '/^[\w\\\\]*$/',
                'message' => 'Only word characters and backslashes are allowed.'
            ],
            [
                [
                    'controllerName'
                ],
                'match',
                'pattern' => '/Controller$/',
                'message' => 'Controller class name must be suffixed with "Controller".'
            ],
            [
                [
                    'controllerName'
                ],
                'match',
                'pattern' => '/(^|\\\\)[A-Z][^\\\\]+Controller$/',
                'message' => 'Controller class name must start with an uppercase letter.'
            ],
            [
                [
                    'indexWidgetType'
                ],
                'in',
                'range' => [
                    'grid',
                    'list'
                ]
            ],
            [
                [
                    'enableI18N',
                    'enablePjax',
                    'enableDefaultOrder',
                    'enableCrudAction',
                    'onlyQueryCurrentUser'
                ],
                'boolean'
            ],
            [
                [
                    'messageCategory'
                ],
                'validateMessageCategory',
                'skipOnEmpty' => false
            ],
            [
                [
                    'viewPathBase',
                    'modalSize',
                    'defaultOrderField',
                    'defaultOrder'
                ],
                'safe'
            ]
        ] );

    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeLabels()
    {

        return array_merge( parent::attributeLabels(), [
            'modelNamespace'       => '模型类命名空间',
            'modelName'            => '模型类',
            'controllerNamespace'  => '控制器类命名空间',
            'controllerName'       => '控制器类',
            'viewPathBase'         => '视图路径',
            'baseControllerClass'  => '控制器基类',
            'indexWidgetType'      => '列表页面显示类型（小部件）',
            'enablePjax'           => '是否开启Pjax功能',
            'enableI18N'           => '是否支持国际化',
            'modalSize'            => '模态框大小（bootstrap modal size）',
            'enableDefaultOrder'   => '是否支持默认搜索排序',
            'defaultOrderField'    => '默认搜索排序字段',
            'defaultOrder'         => '默认搜索排序顺序',
            'enableCrudAction'     => '是否支持增删改',
            'onlyQueryCurrentUser' => '设置是否在控制器上设置只查询当前用户的数据',
            'actions'              => '控制器支持的action清单'
        ] );

    }

    /**
     *
     * {@inheritdoc}
     */
    public function hints()
    {

        return array_merge( parent::hints(), [
            'modelNamespace'      => 'This is the namespance of the model class to be generated. You should provide a fully
                qualified namespace , e.g., <code>app\models</code>.',
            'modelName'           => 'This is the ActiveRecord class associated with the table that CRUD will be built upon.
                You should provide a fully qualified class name, e.g., <code>Post</code>.',
            'modelNamespace'      => 'This is the namespance of the controller class to be generated. You should provide a fully
                    qualified namespace , e.g., <code>app\controllers</code>.',
            'controllerName'      => 'This is the name of the controller class to be generated. You should
                provide a fully qualified namespaced class (e.g. <code>app\controllers\PostController</code>),
                and class name should be in CamelCase with an uppercase first letter. Make sure the class
                is using the same namespace as specified by your application\'s controllerNamespace property.',
            'viewPathBase'        => 'Specify the directory for storing the view scripts for the controller. You may use path alias here, e.g.,
                <code>/var/www/basic/controllers/views</code>, <code>@app/views</code>.',
            'baseControllerClass' => 'This is the class that the new CRUD controller class will extend from.
                You should provide a fully qualified class name, e.g., <code>yii\web\Controller</code>.',
            'indexWidgetType'     => 'This is the widget type to be used in the index page to display list of the models.
                You may choose either <code>GridView</code> or <code>ListView</code>',
            'enablePjax'          => 'This indicates whether the generator should wrap the <code>GridView</code> or <code>ListView</code>
                widget on the index page with <code>yii\widgets\Pjax</code> widget. Set this to <code>true</code> if you want to get
                sorting, filtering and pagination without page refreshing.'
        ] );

    }

    /**
     *
     * {@inheritdoc}
     */
    public function requiredTemplates()
    {

        return [
            'controller.php'
        ];

    }

    /**
     *
     * {@inheritdoc}
     */
    public function stickyAttributes()
    {

        return array_merge( parent::stickyAttributes(), [
            'baseControllerClass',
            'indexWidgetType',
            'modelNamespace',
            // 'modelName',
            'controllerNamespace',
            // 'controllerName',
            'viewPathBase'
        ] );

    }

    /**
     * Checks if model class is valid
     */
    public function validateModelClass()
    {

        /** @var $class ActiveRecord */
        $class = $this->modelClass;
        $pk = $class::primaryKey();
        if ( empty( $pk ) ) {
            $this->addError( 'modelClass', "The table associated with $class must have primary key(s)." );
        }

    }

    /**
     *
     * {@inheritdoc}
     */
    public function generate()
    {

        $controllerFile = Yii::getAlias( '@' . str_replace( '\\', '/', ltrim( $this->controllerClass, '\\' ) ) . '.php' );
        $files = [
            new CodeFile( $controllerFile, $this->render( 'controller.php' ) )
        ];
        if ( !empty( $this->searchModelClass ) ) {
            $searchModel = Yii::getAlias( '@' . str_replace( '\\', '/', ltrim( $this->searchModelClass, '\\' ) . '.php' ) );
            $files [] = new CodeFile( $searchModel, $this->render( 'search.php' ) );
        }
        $viewPath = $this->getViewPath();
        $templatePath = $this->getTemplatePath() . '/views';
        $noPrefixTableName = str_replace( [
            '{',
            '}',
            '%'
        ], '', call_user_func( [
            $this->modelClass,
            'tableName'
        ] ) );
        if ( substr( trim( $this->modelClass, '\\' ), 0, 6 ) == 'Addons' ) {
            // 框架本身的翻译文件
            $this->messageCategory = 'da_' . $noPrefixTableName;
        } else {
            // 应用的翻译文件
            $this->messageCategory = 'app_' . $noPrefixTableName;
        }
        foreach ( scandir( $templatePath ) as $file ) {
            // 忽略创建添加和编辑的页面
            if ( $this->enableCrudAction == false ) {
                if ( in_array( $file, [
                    '_form.php',
                    'create.php',
                    'update.php'
                ] ) ) {
                    continue;
                }
            }
            if ( empty( $this->searchModelClass ) && $file === '_search.php' ) {
                continue;
            }
            if ( is_file( $templatePath . '/' . $file ) && pathinfo( $file, PATHINFO_EXTENSION ) === 'php' ) {
                $files [] = new CodeFile( "$viewPath/$file", $this->render( "views/$file" ) );
            }
        }
        return $files;

    }

    /**
     *
     * @return string the controller ID (without the module ID prefix)
     */
    public function getControllerID()
    {

        $pos = strrpos( $this->controllerClass, '\\' );
        $class = substr( substr( $this->controllerClass, $pos + 1 ), 0, -10 );
        return Inflector::camel2id( $class );

    }

    /**
     *
     * @return string the controller view path
     */
    public function getViewPath()
    {

        // if (empty($this->viewPathBase)) {
        // return Yii::getAlias('@app/views/' . $this->getControllerID());
        // }
        // return Yii::getAlias(str_replace('\\', '/', $this->viewPath));
        if ( $this->viewPathBase ) {
            return Yii::getAlias( str_replace( '\\', '/', $this->viewPathBase ) ) . '/' . $this->getControllerID();
        }
        return null;

    }

    /**
     *
     * @return string
     */
    public function getNameAttribute()
    {

        foreach ( $this->getColumnNames() as $name ) {
            if ( !strcasecmp( $name, 'name' ) || !strcasecmp( $name, 'title' ) ) {
                return $name;
            }
        }
        /* @var $class \yii\db\ActiveRecord */
        $class = $this->modelClass;
        $pk = $class::primaryKey();
        return $pk [ 0 ];

    }

    /**
     * Generates code for active field
     *
     * @param string $attribute
     * @return string
     */
    public function generateActiveField( $attribute )
    {

        return "'<div class=\"col-xs-6\">' . " . $this->generateActiveFieldRaw( $attribute ) . " . '</div>'";

    }

    // 处理状态(status or Status结尾)和类型（type or Type结尾）的字段，根据comment处理
    // 如果备注不是枚举定义的格式者忽略
    // 比如格式, “值类型::IMAGE:图片|STR:字符串|ARRY:数组|ASSOC:关联数组|JSON:json字符串|HTML:html代码|P:段落”
    // 留给后面的逻辑处理
    protected function parseCommentToEnumValues( $attribute, $column )
    {

        // if ($column->name == 'online'
        // || $column->name === 'status'
        // || substr($column->name, - 6) === 'Status'
        // || $column->name === 'type'
        // || substr($column->name, - 6) === 'Type'
        // || substr($column->name,0,2) === 'is') {
        if ( strpos( $column->comment, '|' ) !== false ) {
            // 分割字段备注
            $pieces = explode( "::", $column->comment );
            // 移除备注他字段名称
            array_shift( $pieces );
            // 还原剩下的备注信息
            $comment = implode( "::", $pieces );
            $pieces = explode( '|', $comment );
            $dropDownOptions = [];
            // 如不有一个不满足格式则退出
            $isOk = true;
            foreach ( $pieces as $piece ) {
                $keyName = explode( ':', $piece );
                if ( count( $keyName ) == 2 ) {
                    $dropDownOptions [ $keyName [ 0 ] ] = $keyName [ 1 ];
                } else {
                    $isOk = false;
                    break;
                }
            }
            if ( $isOk ) {
                return "\$form->field(\$model, '$attribute')->dropDownList(" . preg_replace( "/\n\s*/", ' ', VarDumper::export( $dropDownOptions ) ) . ", ['prompt' => ''])";
            }
        }
        // }
        return false;

    }

    public function generateActiveFieldRaw( $attribute )
    {

        $tableSchema = $this->getTableSchema();
        if ( $tableSchema === false || !isset( $tableSchema->columns [ $attribute ] ) ) {
            if ( preg_match( '/^(password|pass|passwd|passcode)$/i', $attribute ) ) {
                return "\$form->field(\$model, '$attribute')->passwordInput()";
            }
            return "\$form->field(\$model, '$attribute')";
        }
        $column = $tableSchema->columns [ $attribute ];
        if ( $code = $this->parseCommentToEnumValues( $attribute, $column ) ) {
            return $code;
        }
        if ( $column->phpType == 'string' && preg_match( '/img|image|pic|pict|cover|logo/', $column->name ) ) {
            $this->useFormClassies [ 'DuAdmin\Widgets\AjaxFileInput' ] = 1;
            return "\$form->field(\$model, '$attribute')->widget(AjaxFileInput::class)";
        }
        if ( substr( $column->name, -2 ) === 'At' ) {
            $this->useFormClassies [ 'DuAdmin\Widgets\DatePicker' ] = 1;
            return "\$form->field(\$model, '$attribute')->widget(DatePicker::class)";
        }
        if ( substr( $column->name, 0, 6 ) == 'enable' || $column->phpType === 'boolean' || $column->type == Schema::TYPE_BOOLEAN ) {
            return "\$form->field(\$model, '$attribute')->checkbox()";
        }
        if ( $column->type === 'text' ) {
            $this->useFormClassies [ 'DuAdmin\Widgets\DefaultEditor' ] = 1;
            return "\$form->field(\$model, '$attribute')->widget(DefaultEditor::getEditorClass(),['mode' => DefaultEditor::MODE_RICH])";
        }
        if ( preg_match( '/^(password|pass|passwd|passcode)$/i', $column->name ) ) {
            $input = 'passwordInput';
        } else {
            $input = 'textInput';
        }
        if ( is_array( $column->enumValues ) && count( $column->enumValues ) > 0 ) {
            $dropDownOptions = [];
            foreach ( $column->enumValues as $enumValue ) {
                $dropDownOptions [ $enumValue ] = Inflector::humanize( $enumValue );
            }
            return "\$form->field(\$model, '$attribute')->dropDownList(" . preg_replace( "/\n\s*/", ' ', VarDumper::export( $dropDownOptions ) ) . ", ['prompt' => ''])";
        }
        if ( $column->phpType !== 'string' || $column->size === null ) {
            return "\$form->field(\$model, '$attribute')->$input()";
        }
        return "\$form->field(\$model, '$attribute')->$input(['maxlength' => true])";

    }

    /**
     * Generates code for active search field
     *
     * @param string $attribute
     * @return string
     */
    public function generateActiveSearchField( $attribute )
    {

        $field = "\$form->field(\$model, '$attribute')";
        $tableSchema = $this->getTableSchema();
        if ( $tableSchema === false ) {
            $field = "\$form->field(\$model, '$attribute')";
        } else {
            $column = $tableSchema->columns [ $attribute ];
            if ( $code = $this->parseCommentToEnumValues( $attribute, $column ) ) {
                $field = $code;
            } else {
                if ( $column->type == 'text' ) {
                    $field = "\$form->field(\$model, '$attribute')->textarea(['rows' => 6])";
                } else if ( $column->phpType == 'string' && preg_match( '/img|image|pic|pict|cover/', $column->name ) ) {
                    return null; // "\$form->field(\$model, '$attribute')->widget('DuAdmin\Widgets\AjaxFileInput')";
                } else if ( substr( $column->name, -2 ) === 'At' ) {
                    $this->useSearchFormClassies [ 'DuAdmin\Widgets\DatePicker' ] = 1;
                    $field = "\$form->field(\$model, '$attribute')->widget(DatePicker::class,['multidate'=>2])";
                } else if ( substr( $column->name, 0, 6 ) == 'enable' || $column->phpType === 'boolean' || $column->type === Schema::TYPE_BOOLEAN ) {
                    $field = "\$form->field(\$model, '$attribute')->checkbox()";
                }
            }
        }
        return "'<div class=\"col-xs-6\">' . " . $field . " . '</div>'";

    }

    /**
     * Generates column format
     *
     * @param \yii\db\ColumnSchema $column
     * @return string
     */
    public function generateColumnFormat( $column )
    {

        if ( $column->phpType === 'boolean' ) {
            return 'boolean';
        }
        if ( $column->type === 'text' ) {
            return 'ntext';
        }
        if ( in_array( $column->name, [
            'createdAt',
            'updatedAt'
        ] ) ) {
            return 'date';
        }
        if ( $column->type === Schema::TYPE_DATE ) {
            return 'date';
        }
        if ( $column->type === Schema::TYPE_TIME ) {
            return 'time';
        }
        if ( $column->type === Schema::TYPE_TIMESTAMP ) {
            return 'datetime';
        }
        if ( $column->type === Schema::TYPE_DATETIME ) {
            return 'datetime';
        }
        if ( stripos( $column->name, 'email' ) !== false ) {
            return 'email';
        }
        if ( $column->type === Schema::TYPE_STRING && preg_match( '/img|image|pic|pict|cover/', $column->name ) ) {
            return 'image';
        }
        if ( preg_match( '/(\b|[_-])url(\b|[_-])/i', $column->name ) ) {
            return 'url';
        }
        return 'text';

    }

    /**
     * Generates validation rules for the search model.
     *
     * @return array the generated validation rules
     */
    public function generateSearchRules()
    {

        if ( ($table = $this->getTableSchema()) === false ) {
            return [
                "[['" . implode( "', '", $this->getColumnNames() ) . "'], 'safe']"
            ];
        }
        $types = [];
        foreach ( $table->columns as $column ) {
            // 处理时间字段（查询的时候传递的是日期格式的字符串）
            if ( substr( $column->name, -2 ) == 'At' ) {
                $types [ 'safe' ] [] = $column->name;
                continue;
            }
            switch ( $column->type ) {
                case Schema::TYPE_TINYINT :
                case Schema::TYPE_SMALLINT :
                case Schema::TYPE_INTEGER :
                case Schema::TYPE_BIGINT :
                    $types [ 'integer' ] [] = $column->name;
                    break;
                case Schema::TYPE_BOOLEAN :
                    $types [ 'boolean' ] [] = $column->name;
                    break;
                case Schema::TYPE_FLOAT :
                case Schema::TYPE_DOUBLE :
                case Schema::TYPE_DECIMAL :
                case Schema::TYPE_MONEY :
                    $types [ 'number' ] [] = $column->name;
                    break;
                case Schema::TYPE_DATE :
                case Schema::TYPE_TIME :
                case Schema::TYPE_DATETIME :
                case Schema::TYPE_TIMESTAMP :
                default :
                    $types [ 'safe' ] [] = $column->name;
                    break;
            }
        }
        $rules = [];
        foreach ( $types as $type => $columns ) {
            $rules [] = "[['" . implode( "', '", $columns ) . "'], '$type']";
        }
        return $rules;

    }

    /**
     * 是否有字符串字段
     */
    public function hasStringField()
    {

        if ( $table = $this->getTableSchema() ) {
            foreach ( $table->columns as $column ) {
                if ( in_array( $column->type, [
                    'string',
                    'char',
                    'text'
                ] ) ) {
                    return true;
                }
            }
        }
        return false;

    }

    /**
     *
     * @return array searchable attributes
     */
    public function getSearchAttributes()
    {

        return $this->getColumnNames();

    }

    /**
     * Generates the attribute labels for the search model.
     *
     * @return array the generated attribute labels (name => label)
     */
    public function generateSearchLabels()
    {

        /* @var $model \yii\base\Model */
        $model = new $this->modelClass();
        $attributeLabels = $model->attributeLabels();
        $labels = [];
        foreach ( $this->getColumnNames() as $name ) {
            if ( isset( $attributeLabels [ $name ] ) ) {
                $labels [ $name ] = $attributeLabels [ $name ];
            } else {
                if ( !strcasecmp( $name, 'id' ) ) {
                    $labels [ $name ] = 'ID';
                } else {
                    $label = Inflector::camel2words( $name );
                    if ( !empty( $label ) && substr_compare( $label, ' id', -3, 3, true ) === 0 ) {
                        $label = substr( $label, 0, -3 ) . ' ID';
                    }
                    $labels [ $name ] = $label;
                }
            }
        }
        return $labels;

    }

    /**
     * Generates search conditions
     *
     * @return array
     */
    public function generateSearchConditions()
    {

        $columns = [];
        if ( ($table = $this->getTableSchema()) === false ) {
            $class = $this->modelClass;
            /* @var $model \yii\base\Model */
            $model = new $class();
            foreach ( $model->attributes() as $attribute ) {
                $columns [ $attribute ] = 'unknown';
            }
        } else {
            foreach ( $table->columns as $column ) {
                $columns [ $column->name ] = $column->type;
            }
        }
        $likeConditions = [];
        $hashConditions = [];
        $dateConditions = [];
        $full_search_columns = [];
        foreach ( $columns as $column => $type ) {
            // 处理时间字段（查询的时候传递的是日期格式的字符串）
            if ( substr( $column, -2 ) == 'At' ) {
                $dateConditions [] = "->andFilterWhere(['DATE_RANGE','{$column}',\$this->{$column}])";
                continue;
            }
            switch ( $type ) {
                case Schema::TYPE_TINYINT :
                case Schema::TYPE_SMALLINT :
                case Schema::TYPE_INTEGER :
                case Schema::TYPE_BIGINT :
                case Schema::TYPE_BOOLEAN :
                case Schema::TYPE_FLOAT :
                case Schema::TYPE_DOUBLE :
                case Schema::TYPE_DECIMAL :
                case Schema::TYPE_MONEY :
                case Schema::TYPE_DATE :
                case Schema::TYPE_TIME :
                case Schema::TYPE_DATETIME :
                case Schema::TYPE_TIMESTAMP :
                    $hashConditions [] = "'{$column}' => \$this->{$column},";
                    break;
                default :
                    $likeKeyword = $this->getClassDbDriverName() === 'pgsql' ? 'ilike' : 'like';
                    $likeConditions [] = "->andFilterWhere(['{$likeKeyword}', '{$column}', \$this->{$column}])";
                    $full_search_columns [] = "'{$column}'";
                    break;
            }
        }
        $conditions = [];
        if ( !empty( $hashConditions ) ) {
            $conditions [] = "\$query->andFilterWhere([\n" . str_repeat( ' ', 12 ) . implode( "\n" . str_repeat( ' ', 12 ), $hashConditions ) . "\n" . str_repeat( ' ', 8 ) . "]);\n";
        }
        if ( !empty( $dateConditions ) ) {
            $conditions [] = "\$query" . implode( "\n" . str_repeat( ' ', 12 ), $dateConditions ) . ";\n";
        }
        if ( !empty( $likeConditions ) ) {
            $conditions [] = "\$query" . implode( "\n" . str_repeat( ' ', 12 ), $likeConditions ) . ";\n";
            // 添加默认搜索的查询构建代码
            $conditions [] = "if (\$full_search = Yii::\$app->request->get('full_search')) {\n" . str_repeat( ' ', 12 ) . "\$query->andFilterWhere(['FULL_SEARCH',[" . implode( ',', $full_search_columns ) . "],\$full_search]);\n" . str_repeat( ' ', 8 ) . "}\n";
        }
        return $conditions;

    }

    /**
     * Generates URL parameters
     *
     * @return string
     */
    public function generateUrlParams()
    {

        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pks = $class::primaryKey();
        if ( count( $pks ) === 1 ) {
            if ( is_subclass_of( $class, 'yii\mongodb\ActiveRecord' ) ) {
                return "'id' => (string)\$model->{$pks[0]}";
            }
            return "'id' => \$model->{$pks[0]}";
        }
        $params = [];
        foreach ( $pks as $pk ) {
            if ( is_subclass_of( $class, 'yii\mongodb\ActiveRecord' ) ) {
                $params [] = "'$pk' => (string)\$model->$pk";
            } else {
                $params [] = "'$pk' => \$model->$pk";
            }
        }
        return implode( ', ', $params );

    }

    /**
     * Generates action parameters
     *
     * @return string
     */
    public function generateActionParams()
    {

        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pks = $class::primaryKey();
        if ( count( $pks ) === 1 ) {
            $pk = $pks[0];
            return '$' . $pk;
        }
        return '$' . implode( ', $', $pks );

    }

    /**
     * Generates parameter tags for phpdoc
     *
     * @return array parameter tags for phpdoc
     */
    public function generateActionParamComments()
    {

        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pks = $class::primaryKey();
        if ( ($table = $this->getTableSchema()) === false ) {
            $params = [];
            foreach ( $pks as $pk ) {
                $params [] = '@param ' . (strtolower( substr( $pk, -2 ) ) === 'id' ? 'integer' : 'string') . ' $' . $pk;
            }
            return $params;
        }
        if ( count( $pks ) === 1 ) {
            return [
                '@param ' . $table->columns [ $pks [ 0 ] ]->phpType . ' $id'
            ];
        }
        $params = [];
        foreach ( $pks as $pk ) {
            $params [] = '@param ' . $table->columns [ $pk ]->phpType . ' $' . $pk;
        }
        return $params;

    }

    /**
     * Returns table schema for current model class or false if it is not an active record
     *
     * @return bool|\yii\db\TableSchema
     */
    public function getTableSchema()
    {

        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        if ( is_subclass_of( $class, 'yii\db\ActiveRecord' ) ) {
            return $class::getTableSchema();
        }
        return false;

    }

    /**
     *
     * @return array model column names
     */
    public function getColumnNames()
    {

        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        if ( is_subclass_of( $class, 'yii\db\ActiveRecord' ) ) {
            return $class::getTableSchema()->getColumnNames();
        }
        /* @var $model \yii\base\Model */
        $model = new $class();
        return $model->attributes();

    }

    /**
     *
     * @return string|null driver name of modelClass db connection.
     *         In case db is not instance of \yii\db\Connection null will be returned.
     * @since 2.0.6
     */
    protected function getClassDbDriverName()
    {

        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $db = $class::getDb();
        return $db instanceof \yii\db\Connection ? $db->driverName : null;

    }

    public function getLinkFuncName()
    {

        $links = [
            'default' => 'linkButtonWithSimpleModal',
            'lg'      => 'linkButtonWithBigSimpleModal',
            'sm'      => 'linkButtonWithSmallSimpleModal'
        ];
        return $links [ $this->modalSize ];

    }

    public function getModalSizeClass()
    {

        $classNames = [
            'default' => '',
            'lg'      => 'modal-lg',
            'sm'      => 'modal-sm'
        ];
        return $classNames [ $this->modalSize ];

    }
}
