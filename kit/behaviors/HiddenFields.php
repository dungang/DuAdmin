<?php

namespace app\kit\behaviors;

use app\kit\helpers\KitHelper;
use yii\base\Behavior;
use yii\base\Controller;

class HiddenFields extends Behavior
{

    public function events()
    {
        return [
            Controller::EVENT_AFTER_ACTION => 'afterAction'
        ];
    }

    /**
     * @param \yii\base\ActionEvent $event
     */
    public function afterAction($event)
    {

        if ($this->owner->hasProperty('hidden') && $this->owner->hidden) {
            $fields = explode(',', $this->owner->hidden);
            var_dump($event->result);die;
            $event->result = KitHelper::walkRecursiveRemove($event->result, function ($v, $k) use ($fields) {
                return in_array($k, $fields);
            });
        }
    }
}
