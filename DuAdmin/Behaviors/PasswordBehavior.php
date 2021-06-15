<?php

namespace DuAdmin\Behaviors;

use yii\base\Behavior;
use yii\base\Model;

/**
 * 当没有设置密码的时候，忽略，
 * 设置了则更新或者设置
 *
 * @author admin
 *
 */
class PasswordBehavior extends Behavior {

  public function events() {

    return [
        Model::EVENT_AFTER_VALIDATE => 'setPasswordHash'
    ];

  }

  public function setPasswordHash($event) {

    if (! empty( $this->owner->password ) && $this->owner->hasMethod( 'setPassword' )) {
      $this->owner->setPassword( $this->owner->password );
    }

  }
}
