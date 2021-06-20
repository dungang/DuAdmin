<?php

namespace Addons\Cms\Models;

/**
 * This is the ActiveQuery class for [[Flash]].
 *
 * @see Flash
 */
class FlashQuery extends \DuAdmin\Mysql\ActiveQuery {

  public function getCarouselLimited( $size = 5 ) {

    return $this->orderBy( 'sort desc' )->limit( $size )->all();

  }

  /**
   *
   * {@inheritdoc}
   * @return Flash[]|array
   */
  public function all( $db = null ) {

    return parent::all( $db );

  }

  /**
   *
   * {@inheritdoc}
   * @return Flash|array|null
   */
  public function one( $db = null ) {

    return parent::one( $db );

  }
}