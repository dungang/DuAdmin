<?php

namespace Backend\Models;

use DuAdmin\Rbac\Item;

class AuthRole extends AuthItem {

  public function init() {

    $this->type = Item::TYPE_ROLE;

  }

  /**
   *
   * {@inheritdoc}
   * @return AuthItemQuery the active query used by this AR class.
   */
  public static function find() {

    return (new AuthItemQuery( get_called_class() ))->where( [
        'type' => Item::TYPE_ROLE
    ] );

  }
}

