<?php
namespace app\generators\language;

use app\generators\Generator as BaseGenerator;
use yii\helpers\FileHelper;
use yii\db\Connection;
use app\generators\CodeFile;
use yii\helpers\Inflector;

class Generator extends BaseGenerator
{

    public $db = 'db';

    /**
     * 消息存储路径
     *
     * @var string
     */
    public $messagesPath = "";

    /**
     * 生成的语言
     *
     * @var string
     */
    public $language = "zh-CN";

    /**
     * 消息分类文件
     *
     * @var string
     */
    public $messagesCategory = '';

    /**
     * 选择表
     *
     * @var array
     */
    public $tables;

    public function getName()
    {
        return '中文翻译';
    }

    public function rules()
    {
        return [
            [
                [
                    'messagesPath',
                    'messagesCategory',
                    'language'
                ],
                'filter',
                'filter' => 'trim'
            ],
            [
                [
                    'messagesPath',
                    'messagesCategory',
                    'language',
                    'tables'
                ],
                'required'
            ],
            [
                [
                    'messagesPath',
                    'messagesCategory',
                    'language'
                ],
                'string'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'language' => '语言',
            'tables' => '翻译的表',
            'messagesPath' => '翻译存储文件目录',
            'messagesCategory' => '翻译文件'
        ];
    }

    public function attributeHints()
    {
        return [
            'language' => '根据表的注释语言选择，默认选择的是中文:zh-CN',
            'messagesPath' => '翻译存储文件目录',
            'messagesCategory' => '翻译文件',
            'tables' => '根据业务选择翻译的表，最后把多个表的翻译合并去重在保存'
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '该生成器根据数据库中指定的表来生成对应的中文本地语言。';
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

    public function getMessagesPaths()
    {
        $messagesPaths = [
            '@Backend/messages' => 'fontend.php',
            '@Frontend/messages' => 'backend.php'
        ];
        $dirs = FileHelper::findDirectories(\Yii::$app->basePath . '/Addons', [
            'recursive' => false
        ]);
        foreach ($dirs as $dir) {
            $addon = basename($dir);
            $messageFile = 'addon_' . Inflector::camel2id($addon, '_') . '.php';
            $alias = '@Addons/' . basename($dir) . '/resource/messages';
            $messagesPaths[$alias] = $messageFile;
        }
        return $messagesPaths;
    }

    public function generate()
    {
        $db = $this->getDbConnection();

        $tableNamesIn = implode(',', array_map(function ($table) {
            return "'" . $table . "'";
        }, $this->tables));

        $tableInfos = $db->createCommand("SELECT TABLE_NAME tableName,TABLE_COMMENT tableComment
FROM INFORMATION_SCHEMA.TABLES
WHERE table_schema='" . getenv('DB_DATABASE') . "' AND TABLE_NAME IN (" . $tableNamesIn . ")")->queryAll();
       
        $tablePrefixLen = strlen($db->tablePrefix);
        $trans = [];
        foreach ($tableInfos as $tableInfo) {
            
            $tableName = $tableInfo['tableName'];
            $tableComment = $tableInfo['tableComment'];

            if (substr($tableName, 0, $tablePrefixLen) == $db->tablePrefix) {
                $words = Inflector::camel2words(substr($tableName, $tablePrefixLen));
                
                $trans[$words] = $tableComment;
            } else {
                $words = Inflector::id2camel($tableName);
                $trans[$words] = $tableComment;
            }
            $words = Inflector::pluralize($words);
            $trans[$words] = $tableComment;
            $tableSchema = $db->getTableSchema($tableName);
            $columns = $tableSchema->columns;
            foreach ($columns as $column) {
                if($column->name == 'id') {
                    continue;
                }
                $pieces = explode("::", $column->comment);
                $columnComment = array_shift($pieces);
                $columnWords = Inflector::camel2words($column->name);
                if (! empty($columnWords) && substr_compare($columnWords, ' id', - 3, 3, true) === 0) {
                    $columnWords = substr($columnWords, 0, - 3) . ' ID';
                }
                $trans[$columnWords] = $columnComment;
            }
        }
        return [
            new CodeFile(\Yii::getAlias($this->messagesPath) . '/' . $this->language . '/' . $this->messagesCategory, $this->render('message.php', [
                'trans' => $trans
            ]))
        ];
    }
}

