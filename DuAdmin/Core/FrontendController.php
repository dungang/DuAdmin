<?php

namespace DuAdmin\Core;

use DuAdmin\Filters\AccessFilter;
use voku\helper\HtmlMin;

/**
 * 前端控制器基类
 * 需要登陆
 *
 * @author Lenovo
 *
 */
abstract class FrontendController extends BaseController {

  /**
   * 游客可以访问的action清单
   *
   * @var array|string
   */
  public $guestActions = [ ];

  /**
   * 登录用户可以访问的action清单
   *
   * @var array|string
   */
  public $userActions = [ ];

  public function behaviors() {

    $bs = parent::behaviors();
    // 注册访问控制行为
    // 必须把行为放在第一个位置
    array_unshift( $bs, AccessFilter::class );
    return $bs;

  }

  public function render( $view, $params = [ ] ) {

    $htmlMini = new HtmlMin();
    return $htmlMini->minify( parent::render( $view, $params ) );

  }
}
