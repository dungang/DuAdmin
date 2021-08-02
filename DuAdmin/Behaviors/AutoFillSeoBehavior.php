<?php


namespace DuAdmin\Behaviors;


use DuAdmin\Helpers\JiebaHelper;
use DuAdmin\Helpers\QueryListHelper;
use DuAdmin\Mysql\ActiveRecord;
use yii\base\Behavior;

class AutoFillSeoBehavior extends Behavior
{
    /**
     * @var string 数据来源字段
     */
    public $source = 'intro';

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'autoFill',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'autoFill',
        ];
    }

    public function autoFill($event) {
        $model = $this->owner;
        if ( empty( $model['keywords'] ) ) {
            $model['keywords'] = JiebaHelper::extraKeywords( $model[$this->source] );
        }
        if ( empty( $model['description'] ) ) {
            $model['description'] = QueryListHelper::extraDescription( $model[$this->source] );
        }
    }
}