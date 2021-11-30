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

    public $counterField = 'viewCount';

    public $counterGap = 1;

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
        if ($model->hasProperty($this->counterField)) {
            $model->updateCounters([
                $this->counterField => $this->counterGap
            ]);
        }
    }
}

