<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\generators\api;

use Yii;
use yii\db\Schema;
use app\generators\CodeFile;
use yii\helpers\Inflector;
use DuAdmin\Mysql\ActiveRecord;

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
class Generator extends \app\generators\Generator {

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
    public $baseControllerClass = 'DuAdmin\Core\ApiController';

    /**
     * 设置是否在控制器上设置只查询当前用户的数据
     *
     * @var boolean
     */
    public $onlyQueryCurrentUser = false;

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
    public function getName() {
        return 'API生成器';
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getDescription() {
        return '该生成器将会根据指定的数据模型生成一个API控制器（创建，读取，更新，删除）';
    }

    public function getModelClass() {
        if ( $this->modelName ) {
            return $this->modelNamespace . '\\' . $this->modelName;
        }
        return null;
    }

    public function getSearchModelClass() {
        if ( $this->modelName ) {
            return $this->modelNamespace . '\\' . $this->modelName . 'Search';
        }
        return null;
    }

    public function getControllerClass() {
        if ( $this->controllerName ) {
            return $this->controllerNamespace . '\\' . $this->controllerName;
        }
        return null;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function rules() {
        return array_merge( parent::rules(), [
            [
                [
                    'modelNamespace',
                    'modelName',
                    'controllerNamespace',
                    'controllerName',
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
                    'baseControllerClass',
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
                    'enableDefaultOrder',
                    'onlyQueryCurrentUser'
                ],
                'boolean'
            ],
            [
                [
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
    public function attributeLabels() {
        return array_merge( parent::attributeLabels(), [
            'modelNamespace'       => '模型类命名空间',
            'modelName'            => '模型类',
            'controllerNamespace'  => '控制器类命名空间',
            'controllerName'       => '控制器类',
            'baseControllerClass'  => '控制器基类',
            'enableDefaultOrder'   => '是否支持默认搜索排序',
            'defaultOrderField'    => '默认搜索排序字段',
            'defaultOrder'         => '默认搜索排序顺序',
            'onlyQueryCurrentUser' => '设置是否在控制器上设置只查询当前用户的数据',
            'actions'              => '控制器支持的action清单'
            ] );
    }

    /**
     *
     * {@inheritdoc}
     */
    public function hints() {
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
            'baseControllerClass' => 'This is the class that the new CRUD controller class will extend from.
                You should provide a fully qualified class name, e.g., <code>yii\web\Controller</code>.',
            ] );
    }

    /**
     *
     * {@inheritdoc}
     */
    public function requiredTemplates() {
        return [
            'controller.php'
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function stickyAttributes() {
        return array_merge( parent::stickyAttributes(), [
            'baseControllerClass',
            'modelNamespace',
            'controllerNamespace',
            ] );
    }

    /**
     * Checks if model class is valid
     */
    public function validateModelClass() {
        /* @var $class ActiveRecord */
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
    public function generate() {
        $controllerFile = Yii::getAlias( '@' . str_replace( '\\', '/', ltrim( $this->controllerClass, '\\' ) ) . '.php' );

        $files = [
            new CodeFile( $controllerFile, $this->render( 'controller.php' ) )
        ];

        if ( !empty( $this->searchModelClass ) ) {
            $searchModel = Yii::getAlias( '@' . str_replace( '\\', '/', ltrim( $this->searchModelClass, '\\' ) . '.php' ) );
            $files[] = new CodeFile( $searchModel, $this->render( 'search.php' ) );
        }

        return $files;
    }

    /**
     *
     * @return string the controller ID (without the module ID prefix)
     */
    public function getControllerID() {
        $pos = strrpos( $this->controllerClass, '\\' );
        $class = substr( substr( $this->controllerClass, $pos + 1 ), 0, -10 );

        return Inflector::camel2id( $class );
    }

    /**
     *
     * @return string
     */
    public function getNameAttribute() {
        foreach ( $this->getColumnNames() as $name ) {
            if ( !strcasecmp( $name, 'name' ) || !strcasecmp( $name, 'title' ) ) {
                return $name;
            }
        }
        /* @var $class \yii\db\ActiveRecord */
        $class = $this->modelClass;
        $pk = $class::primaryKey();

        return $pk[ 0 ];
    }

    /**
     * Generates column format
     *
     * @param \yii\db\ColumnSchema $column
     * @return string
     */
    public function generateColumnFormat( $column ) {
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

        if ( preg_match( '/img|image|pic|pict|cover/', $column->name ) ) {
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
    public function generateSearchRules() {
        if ( ($table = $this->getTableSchema()) === false ) {
            return [
                "[['" . implode( "', '", $this->getColumnNames() ) . "'], 'safe']"
            ];
        }
        $types = [];
        foreach ( $table->columns as $column ) {
            // 处理时间字段（查询的时候传递的是日期格式的字符串）
            if ( substr( $column->name, -2 ) == 'At' ) {
                $types[ 'safe' ][] = $column->name;
                continue;
            }
            switch ( $column->type ) {
                case Schema::TYPE_TINYINT:
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    $types[ 'integer' ][] = $column->name;
                    break;
                case Schema::TYPE_BOOLEAN:
                    $types[ 'boolean' ][] = $column->name;
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $types[ 'number' ][] = $column->name;
                    break;
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                default:
                    $types[ 'safe' ][] = $column->name;
                    break;
            }
        }

        $rules = [];
        foreach ( $types as $type => $columns ) {
            $rules[] = "[['" . implode( "', '", $columns ) . "'], '$type']";
        }

        return $rules;
    }

    /**
     * 是否有字符串字段
     */
    public function hasStringField() {
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
    public function getSearchAttributes() {
        return $this->getColumnNames();
    }

    /**
     * Generates the attribute labels for the search model.
     *
     * @return array the generated attribute labels (name => label)
     */
    public function generateSearchLabels() {
        /* @var $model \yii\base\Model */
        $model = new $this->modelClass();
        $attributeLabels = $model->attributeLabels();
        $labels = [];
        foreach ( $this->getColumnNames() as $name ) {
            if ( isset( $attributeLabels[ $name ] ) ) {
                $labels[ $name ] = $attributeLabels[ $name ];
            } else {
                if ( !strcasecmp( $name, 'id' ) ) {
                    $labels[ $name ] = 'ID';
                } else {
                    $label = Inflector::camel2words( $name );
                    if ( !empty( $label ) && substr_compare( $label, ' id', -3, 3, true ) === 0 ) {
                        $label = substr( $label, 0, -3 ) . ' ID';
                    }
                    $labels[ $name ] = $label;
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
    public function generateSearchConditions() {
        $columns = [];
        if ( ($table = $this->getTableSchema()) === false ) {
            $class = $this->modelClass;
            /* @var $model \yii\base\Model */
            $model = new $class();
            foreach ( $model->attributes() as $attribute ) {
                $columns[ $attribute ] = 'unknown';
            }
        } else {
            foreach ( $table->columns as $column ) {
                $columns[ $column->name ] = $column->type;
            }
        }

        $likeConditions = [];
        $hashConditions = [];
        $dateConditions = [];
        $full_search_columns = [];
        foreach ( $columns as $column => $type ) {
            // 处理时间字段（查询的时候传递的是日期格式的字符串）
            if ( substr( $column, -2 ) == 'At' ) {
                $dateConditions[] = "->andFilterWhere(['DATE_RANGE','{$column}',\$this->{$column}])";
                continue;
            }
            switch ( $type ) {
                case Schema::TYPE_TINYINT:
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                case Schema::TYPE_BOOLEAN:
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    $hashConditions[] = "'{$column}' => \$this->{$column},";
                    break;
                default:
                    $likeKeyword = $this->getClassDbDriverName() === 'pgsql' ? 'ilike' : 'like';
                    $likeConditions[] = "->andFilterWhere(['{$likeKeyword}', '{$column}', \$this->{$column}])";
                    $full_search_columns[] = "'{$column}'";
                    break;
            }
        }

        $conditions = [];
        if ( !empty( $hashConditions ) ) {
            $conditions[] = "\$query->andFilterWhere([\n" . str_repeat( ' ', 12 ) . implode( "\n" . str_repeat( ' ', 12 ), $hashConditions ) . "\n" . str_repeat( ' ', 8 ) . "]);\n";
        }
        if ( !empty( $dateConditions ) ) {
            $conditions[] = "\$query" . implode( "\n" . str_repeat( ' ', 12 ), $dateConditions ) . ";\n";
        }
        if ( !empty( $likeConditions ) ) {
            $conditions[] = "\$query" . implode( "\n" . str_repeat( ' ', 12 ), $likeConditions ) . ";\n";
            // 添加默认搜索的查询构建代码
            $conditions[] = "if (\$full_search = Yii::\$app->request->get('full_search')) {\n" . str_repeat( ' ', 12 ) . "\$query->andFilterWhere(['FULL_SEARCH',[" . implode( ',', $full_search_columns ) . "],\$full_search]);\n" . str_repeat( ' ', 8 ) . "}\n";
        }

        return $conditions;
    }

    /**
     * Generates URL parameters
     *
     * @return string
     */
    public function generateUrlParams() {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pks = $class::primaryKey();
        if ( count( $pks ) === 1 ) {
            if ( is_subclass_of( $class, 'yii\mongodb\ActiveRecord' ) ) {
                return "'id' => (string)\$model->{$pks[ 0 ]}";
            }

            return "'id' => \$model->{$pks[ 0 ]}";
        }

        $params = [];
        foreach ( $pks as $pk ) {
            if ( is_subclass_of( $class, 'yii\mongodb\ActiveRecord' ) ) {
                $params[] = "'$pk' => (string)\$model->$pk";
            } else {
                $params[] = "'$pk' => \$model->$pk";
            }
        }

        return implode( ', ', $params );
    }

    /**
     * Generates action parameters
     *
     * @return string
     */
    public function generateActionParams() {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pks = $class::primaryKey();
        if ( count( $pks ) === 1 ) {
            return '$id';
        }

        return '$' . implode( ', $', $pks );
    }

    /**
     * Generates parameter tags for phpdoc
     *
     * @return array parameter tags for phpdoc
     */
    public function generateActionParamComments() {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pks = $class::primaryKey();
        if ( ($table = $this->getTableSchema()) === false ) {
            $params = [];
            foreach ( $pks as $pk ) {
                $params[] = '@param ' . (strtolower( substr( $pk, -2 ) ) === 'id' ? 'integer' : 'string') . ' $' . $pk;
            }

            return $params;
        }
        if ( count( $pks ) === 1 ) {
            return [
                '@param ' . $table->columns[ $pks[ 0 ] ]->phpType . ' $id'
            ];
        }

        $params = [];
        foreach ( $pks as $pk ) {
            $params[] = '@param ' . $table->columns[ $pk ]->phpType . ' $' . $pk;
        }

        return $params;
    }

    /**
     * Returns table schema for current model class or false if it is not an active record
     *
     * @return bool|\yii\db\TableSchema
     */
    public function getTableSchema() {
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
    public function getColumnNames() {
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
    protected function getClassDbDriverName() {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $db = $class::getDb();
        return $db instanceof \yii\db\Connection ? $db->driverName : null;
    }

    public function getLinkFuncName() {
        $links = [
            'default' => 'linkButtonWithSimpleModal',
            'lg'      => 'linkButtonWithBigSimpleModal',
            'sm'      => 'linkButtonWithSmallSimpleModal'
        ];
        return $links[ $this->modalSize ];
    }

    public function getModalSizeClass() {
        $classNames = [
            'default' => '',
            'lg'      => 'modal-lg',
            'sm'      => 'modal-sm'
        ];
        return $classNames[ $this->modalSize ];
    }

}
