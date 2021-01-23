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
     * 选择需要生成模板数据的表格
     *
     * @var array
     */
    public $tables = [];

    public $db = 'db';

    public $fixturePath = "Tests/Unit/Fixtures";

    public $appName = "Backend";

    public function getName()
    {
        return "测试夹具";
    }

    /**
     * 获取测试夹具的命名空间
     *
     * @return void
     */
    public function getFixtureNamespace(){
        return str_replace('/','\\',$this->appName . '\Tests\Unit\Fixtures');
    }

    public function getModelNamespace(){
        return str_replace('/','\\',$this->appName . '\Models');
    }

    public function rules()
    {
        return [
            [
                [
                    'language',
                    'appName'
                ],
                'filter',
                'filter' => 'trim'
            ],
            [
                [
                    'language',
                    'appName',
                    'tables'
                ],
                'required'
            ],
            [
                [
                    'language',
                    'appName'
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
            'appName' => '模板数据所属App',
        ];
    }

    public function attributeHints()
    {
        return [
            //'tables' => '可以多选表，每个表格生成一个模板数据文件'
        ];
    }

    public function getDescription()
    {
        return "该生成器通过YII的fixtures(测试夹具功能)，<br/>根据选择的表生成对应的模板数据和测试夹具类文件,<br/>执行完成后，还需要使用 <code>php yii dua-fixture/generate-all</code> 根据提示选择对应的app生成数据样板,<br/>执行<code>yii dua-fixture/load \"*\"</code>根据提示装载对应app的数据";
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
                return "\$faker->randomElement([" . implode(',', $elems) . "])";
            }
        }
        return $isOk;
    }

    public function generateFixtuireColumnMap($columns)
    {
        $map = [];

        foreach ($columns as $column) {
            if (in_array($column->name,['id'/*,'createdAt','updatedAt'*/])) {
                continue;
            }
            if ($column->name == 'userId') {
                if($column->isPrimaryKey) {
                    $map[$column->name] = '$faker->id($this->count)';
                } else {
                    $map[$column->name] = 1;
                }
                continue;
            }
            if (preg_match('/img|image|pic|pict|cover|avatar|logo/', $column->name)) {
                $map[$column->name] = '$faker->imageUrl(480,480)';
                continue;
            }
            if ($column->name == 'uuid' || substr($column->name, - 2) == 'No') {
                $map[$column->name] = 'uniqid()';
                continue;
            }
            if ($faker = $this->parseEnum($column)) {
                $map[$column->name] = $faker;
                continue;
            }
            // 处理时间字段（查询的时候传递的是日期格式的字符串）
            if (substr($column->name, - 2) == 'At') {
                $map[$column->name] = 'date("Y-m-d H:i:s")';
                continue;
            }
            switch ($column->type) {
                case Schema::TYPE_TINYINT:
                    $map[$column->name] = '$faker->numberBetween(0,3)';
                    break;
                case Schema::TYPE_SMALLINT:
                    $map[$column->name] = '$faker->numberBetween(1,$this->count)';
                    break;
                case Schema::TYPE_INTEGER:
                    $map[$column->name] = '$faker->numberBetween(1,$this->count)';
                    break;
                case Schema::TYPE_BIGINT:
                    $map[$column->name] = '$faker->numberBetween(1,$this->count)';
                    break;
                case Schema::TYPE_BOOLEAN:
                    $map[$column->name] = '$faker->numberBetween(0,1)';
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $map[$column->name] = '$faker->randomFloat(2,1,8)';
                    break;
                case Schema::TYPE_DATE:
                    $map[$column->name] = '$faker->date()';
                    break;
                case Schema::TYPE_TIME:
                    $map[$column->name] = '$faker->time()';
                    break;
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    $map[$column->name] = 'date("Y-m-d H:i:s")';
                    break;
                case Schema::TYPE_TEXT:
                    $map[$column->name] = '$faker->text(200)';
                    break;
                default:
                    if ($column->name == 'name') {
                        $map[$column->name] = '$faker->name';
                    } else if ($column->name == 'title') {
                        $map[$column->name] = '$faker->title';
                    } else if ($column->name == 'email') {
                        $map[$column->name] = '$faker->email';
                    } else if ($column->name == 'mobile') {
                        $map[$column->name] = '$faker->mobile';
                    } else if ($column->name == 'avatar') {
                        $map[$column->name] = '$faker->url';
                    } else if ($column->name == 'username') {
                        $map[$column->name] = '$faker->userName';
                    } else if ($column->name == 'password') {
                        $map[$column->name] = '$faker->password';
                    } else if ($column->name == 'slug') {
                        $map[$column->name] = '$faker->slug';
                    } else {
                        $map[$column->name] = '$faker->text('. $column->size .')';
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
        $fakerTemplatePath = \Yii::getAlias($this->getFixtureTemplatePath());
        $fixturePath = \Yii::getAlias($this->getFixturePath());
        if (is_dir($fixturePath) == false) {
            FileHelper::createDirectory($fixturePath);
        }
        if (is_dir($fakerTemplatePath) == false) {
            FileHelper::createDirectory($fakerTemplatePath);
        }
        foreach ($this->tables as $tableName) {
            $tableSchema = $schema->getTableSchema($tableName);
            $columns = $tableSchema->columns;
            $columnMap = $this->generateFixtuireColumnMap($columns);
            $modelName = Inflector::id2camel(substr($tableName, $tablePixLength), '_');

            //生成faker模板
            $templateFile = $fakerTemplatePath . '/' . $modelName . '.php';
            $codeFiles[] = new CodeFile($templateFile, $this->render('template.php', [
                'columns' => $columnMap,
                'locale' => $this->language,
            ]));

            //生成测试夹具类文件
            $fixtureFile = $fixturePath .'/'.$modelName . 'Fixture.php';
            $codeFiles[] = new CodeFile($fixtureFile, $this->render('fixture.php', [
                'fixtureName' => $modelName . 'Fixture',
                'modelClass' => $this->getModelNamespace() . '\\' . $modelName,
                'dataName' => $modelName
            ]));
        }
        return $codeFiles;
    }

    public function getFixtureTemplatePath(){
        return '@' . $this->appName .'/'. $this->fixturePath . '/templates';
    }

    public function getFixturePath(){
        return '@' . $this->appName .'/'. $this->fixturePath;
    }

    public function findFixtureAppNames()
    {
        $appNames = [
            'Backend',
            'Frontend'
        ];
        $addonNames = $this->getAddonNames();
        foreach ($addonNames as $name) {
            $appNames[] = 'Addons/' . $name ;
        }
        return $appNames;
    }
}

