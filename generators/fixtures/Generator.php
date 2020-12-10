<?php
namespace app\generators\fixtures;

use app\generators\Generator as BaseGenerator;
use yii\db\Connection;
use app\generators\CodeFile;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\db\Schema;

/**
 * 测试夹具，生成模拟数据
 *
 * @author dungang<dungang@126.com>
 * @since 2020年12月10日
 */
class Generator extends BaseGenerator
{

    /**
     * 默认语言
     *
     * @var string
     */
    public $language = 'zh-CN';

    /**
     * 默认模板生成路径
     *
     * @var string
     */
    public $fixtureTemplatePath = "@Backend/tests/unit/fixtures";

    /**
     * 选择需要生成模板数据的表格
     *
     * @var array
     */
    public $tables = [];

    /**
     * 数量
     *
     * @var integer
     */
    public $count = 5;

    public $db = 'db';

    public function getName()
    {
        return "测试夹具";
    }

    public function rules()
    {
        return [
            [
                [
                    'language',
                    'fixtureTemplatePath'
                ],
                'filter',
                'filter' => 'trim'
            ],
            [
                [
                    'language',
                    'fixtureTemplatePath',
                    'count',
                    'tables'
                ],
                'required'
            ],
            [
                [
                    'language',
                    'fixtureTemplatePath'
                ],
                'string'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'language' => '语言',
            'tables' => '数据表',
            'fixtureTemplatePath' => '模板数据生成路径',
            'count' => '生成条数'
        ];
    }

    public function attributeHints()
    {
        return [
            'tables' => '可以多选表，每个表格生成一个模板数据文件'
        ];
    }

    public function getDescription()
    {
        return "该生成器通过YII的fixtures(测试夹具功能)，根据选择的表生成对应的模板数据";
    }

    /**
     *
     * @return Connection the DB connection as specified by [[db]].
     */
    protected function getDbConnection()
    {
        return \Yii::$app->get($this->db, false);
    }

    public function getTableNames()
    {
        return $this->getDbConnection()
            ->getSchema()
            ->getTableNames();
    }

    public function parseEnum($column)
    {
        // 如不有一个不满足格式则退出
        $isOk = false;
        if (strpos($column->comment, '|') !== false) {
            $isOk = true;
            // 分割字段备注
            $pieces = explode("::", $column->comment);
            // 移除备注他字段名称
            array_shift($pieces);
            // 还原剩下的备注信息
            $comment = implode("::", $pieces);
            $pieces = explode('|', $comment);
            $elems = [];
            foreach ($pieces as $piece) {
                $keyName = explode(':', $piece);
                if (count($keyName) == 2) {
                    if (is_string($keyName[0])) {
                        $elems[] = "'" . $keyName[0] . "'";
                    } else {
                        $elems[] = $keyName[0];
                    }
                } else {
                    $isOk = false;
                    break;
                }
            }
            if ($isOk) {
                return "\$fk->randomElement([" . implode(',', $elems) . "])";
            }
        }
        return $isOk;
    }

    public function generateFixtuireColumnMap($columns)
    {
        $map = [];

        foreach ($columns as $column) {
            if (in_array($column->name,['id','createdAt','updatedAt'])) {
                continue;
            }
            if ($column->name == 'userId') {
                $map[$column->name] = 1;
                continue;
            }
            if (preg_match('/img|image|pic|pict|cover|logo/', $column->name)) {
                $map[$column->name] = '$fk->url';
                continue;
            }
            if (substr($column->name, - 2) == 'No') {
                $map[$column->name] = '$fk->uuid';
                continue;
            }
            if ($fk = $this->parseEnum($column)) {
                $map[$column->name] = $fk;
                continue;
            }
            // 处理时间字段（查询的时候传递的是日期格式的字符串）
            if (substr($column->name, - 2) == 'At') {
                $map[$column->name] = '$fk->datetime';
                continue;
            }
            switch ($column->type) {
                case Schema::TYPE_TINYINT:
                    $map[$column->name] = '$fk->numberBetween(0,3)';
                    break;
                case Schema::TYPE_SMALLINT:
                    $map[$column->name] = '$fk->numberBetween(1,5)';
                    break;
                case Schema::TYPE_INTEGER:
                    $map[$column->name] = '$fk->numberBetween(1,10)';
                    break;
                case Schema::TYPE_BIGINT:
                    $map[$column->name] = '$fk->numberBetween(1,20)';
                    break;
                case Schema::TYPE_BOOLEAN:
                    $map[$column->name] = '$fk->numberBetween(0,1)';
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $map[$column->name] = '$fk->randomFloat(1,100)';
                    break;
                case Schema::TYPE_DATE:
                    $map[$column->name] = '$fk->date';
                    break;
                case Schema::TYPE_TIME:
                    $map[$column->name] = '$fk->time';
                    break;
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    $map[$column->name] = '$fk->datetime';
                    break;
                case Schema::TYPE_TEXT:
                    $map[$column->name] = '$fk->text(100)';
                    break;
                default:
                    if ($column->name == 'name') {
                        $map[$column->name] = '$fk->name';
                    } else if ($column->name == 'title') {
                        $map[$column->name] = '$fk->title';
                    } else if ($column->name == 'email') {
                        $map[$column->name] = '$fk->email';
                    } else if ($column->name == 'avatar') {
                        $map[$column->name] = '$fk->url';
                    } else if ($column->name == 'username') {
                        $map[$column->name] = '$fk->userName';
                    } else if ($column->name == 'password') {
                        $map[$column->name] = '$fk->password';
                    } else if ($column->name == 'slug') {
                        $map[$column->name] = '$fk->slug';
                    } else {
                        $map[$column->name] = '$fk->text('. $column->size .')';
                    }
                    break;
            }
        }
        return $map;
    }

    public function generate()
    {
        $schema = $this->getDbConnection()->getSchema();
        $tablePixLength = strlen($this->getDbConnection()->tablePrefix);
        $codeFiles = [];
        foreach ($this->tables as $tableName) {
            $tableSchema = $schema->getTableSchema($tableName);
            $columns = $tableSchema->columns;
            $columnMap = $this->generateFixtuireColumnMap($columns);
            $path = \Yii::getAlias($this->fixtureTemplatePath) . '/' . $this->language;
            if (is_dir($path) == false) {
                FileHelper::createDirectory($path);
            }

            $file = $path . '/' . Inflector::id2camel(substr($tableName, $tablePixLength), '_') . '.php';
            $codeFiles[] = new CodeFile($file, $this->render('template.php', [
                'columns' => $columnMap,
                'locale' => $this->language,
                'count' => $this->count
            ]));
        }
        return $codeFiles;
    }

    public function findFixtureTemplatePaths()
    {
        $paths = [
            '@Backend/tests/unit/fixtures',
            '@Frontend/tests/unit/fixtures'
        ];
        $addonNames = $this->getAddonNames();
        foreach ($addonNames as $name) {
            $paths[] = '@Addons/' . $name . '/tests/unit/fixtures';
        }
        return $paths;
    }
}

