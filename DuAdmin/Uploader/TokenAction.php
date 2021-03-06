<?php

namespace DuAdmin\Uploader;

use DuAdmin\Core\BizException;
use DuAdmin\Helpers\AppHelper;
use Yii;
use yii\base\Action;

/**
 * 获取驱动的验证token
 */
class TokenAction extends Action {

  public function run( $fileType = 'image' ) {

    $driver = AppHelper::getSetting( 'system.storage.driver' );
    if ( empty( $driver ) || strtolower( $driver ) == 'local' ) {
      $driver = "DuAdmin\\Storage\\LocalDriver";
    }
    if ( class_exists( $driver ) ) {
      return call_user_func( [
          Yii::createObject( $driver ),
          'generateUploadToken'
      ], $fileType );
    } else {
      throw new BizException( 'Uploader driver not exists', 404 );
    }

  }
}
