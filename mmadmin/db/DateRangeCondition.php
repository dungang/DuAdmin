<?php
namespace app\mmadmin\db;

use yii\db\conditions\ConditionInterface;

/**
 * 日期区间查询
 * @author dungang<dungang@126.com>
 * @since 2020年12月1日
 */
class DateRangeCondition implements ConditionInterface
{
    /**
     * 日期字段名称
     * @var string
     */
    private $column;
    
    /**
     * 日期区间字符串 
     * 用 ~分割 
     * 比如 2020-12-01~2020-12-31
     * @var string
     */
    private $daterange;

    /**
     * @param string $column 日期字段
     * @param string $daterange 日期区间
     */
    public function __construct(string $column,  $daterange)
    {
        $this->column = $column;
        $this->daterange = $daterange;
    }
    
    public static function fromArrayDefinition($operator, $operands)
    {
        return new static($operands[0],$operands[1]);
    }
    
    /**
     * @return string
     */
    public function getColumn()
    {
        return $this->column;
    }
    
    /**
     * @return string
     */
    public function getDaterange()
    {
        return $this->daterange;
    }
}

