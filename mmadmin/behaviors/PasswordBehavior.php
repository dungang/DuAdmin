<?php

namespace app\mmadmin\behaviors;

use yii\base\Behavior;
use yii\base\Model;

class PasswordBehavior extends Behavior
{

    public function events()
    {
        return [
            Model::EVENT_AFTER_VALIDATE => 'setPasswordHash'
        ];
    }

    public function setPasswordHash($event)
    {
        if (!empty($this->owner->password) && $this->owner->hasMethod('setPassword')) {
            $this->owner->setPassword($this->owner->password);
        }
    }
}
