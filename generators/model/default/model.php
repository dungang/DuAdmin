<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator app\generators\model\Generator */

/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;
/**
 * "<?= $generator->generateTableName($tableName) ?>"表的模型类.
 *
<?php foreach ($properties as $property => $data): ?>
 * @property <?= "{$data['type']} \${$property}"  . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
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
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [<?= empty($rules) ? '' : ("\n            " . implode(",\n            ", $rules) . ",\n        ") ?>];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label,[],$messageCategory) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
<?php if($hints): ?>

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
<?php foreach ($hints as $name => $hint): ?>
            <?= "'$name' => '" . addslashes($hint) . "',\n" ?>
<?php endforeach; ?>
        ];
    }
<?php endif;?>
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->ns) ? $queryClassName : '\\' . $generator->ns . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * {@inheritdoc}
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>

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
