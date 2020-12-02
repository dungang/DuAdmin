<?php
namespace DuAdmin\Behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * 读取统计计数
 *
 * @author dungang
 */
class CountersBehavior extends Behavior
{

    public $counter_field = 'view_count';

    public $counter_gap = 1;

    public function events()
    {
        return [
            'afterView' => 'afterView'
        ];
    }

    public function afterView()
    {
        /* @var $model ActiveRecord */
        $model = $this->owner;
        if ($model->hasProperty($this->counter_field)) {
            $model->updateCounters([
                $this->counter_field => $this->counter_gap
            ]);
        }
    }
}

