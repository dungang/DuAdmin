<?php
namespace app\mmadmin\db;

use yii\db\conditions\ConditionInterface;

/**
 * 默认搜索模糊查询条件
 * @author dungang<dungang@126.com>
 * @since 2020年12月1日
 */
class DefaultSearchCondition implements ConditionInterface
{

    /**
     * 模糊查询的字段
     *
     * @var array
     */
    private $columns;

    /**
     * 查询的关键字
     *
     * @var string
     */
    private $value;

    public function __construct(array $columns, $value)
    {
        $this->columns = $columns;
        $this->value = $value;
    }

    public static function fromArrayDefinition($operator, $operands)
    {
        return new static($operands[0], $operands[1]);
    }

    /**
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}

