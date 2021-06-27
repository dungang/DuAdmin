<?php

namespace DuAdmin\Core;

use DuAdmin\Helpers\AppHelper;
use yii\base\ActionEvent;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

class BaseController extends Controller {

  /**
   * 请求的方法过滤
   *
   * @var array
   */
  public $verbsActions = [ ];

  /**
   *
   * {@inheritdoc}
   */
  public function behaviors() {

    $defaultBehaviors = [ ];
    $defaultBehaviors['verbs'] = [
        'class' => VerbFilter::class,
        'actions' => $this->verbsActions
    ];
    return $defaultBehaviors;

  }

  /**
   *
   * {@inheritdoc}
   * @see \yii\base\Controller::afterAction()
   */
  public function afterAction( $action, $result ) {

    $event = new ActionEvent( $action );
    $event->result = $result;
    $this->trigger( self::EVENT_AFTER_ACTION, $event );
    // 处理action返回的结果
    // DuAdmin/Core/BaseController封装了很多控制器渲染的方法，
    // 很多都是返回的数组结构的结果
    if ( is_array( $result ) ) {
      // 不处理Pjax请求
      if ( AppHelper::isAjaxFormSubmitRequest() || AppHelper::isAjaxJson() ) {
        $event->result = $this->asJson( $result );
      } else {
        if ( isset( $result['view'] ) && ! empty( $result['view'] ) ) {
          // 如果是输出视图组
          $this->renderResult( $event, $result );
        } else if ( isset( $result['redirectUrl'] ) && ! empty( $result['redirectUrl'] ) ) {
          // 如果是跳转转
          $event->result = \Yii::$app->getResponse()->redirect( Url::to( $result['redirectUrl'] ) );
        } else {
          // 默认的控制器的处理逻辑
          unset( $result['view'], $result['redirectUrl'] );
          $event->result = $this->asJson( $result );
        }
      }
    }
    return $event->result;

  }

  /**
   * 默认的渲染处理
   *
   * @param ActionEvent $event
   * @param mixed $result
   */
  private function renderResult( $event, $result ) {

    $event->result = $this->render( $result['view'], $result['data'] );

  }

  /**
   * 设置提示消息内容
   *
   * @param string $status
   * @param string $message
   */
  public final function setFlash( $status, $message ) {

    if ( ! \Yii::$app->request->isAjax ) {
      if ( $status == 'success' ) {
        \Yii::$app->session->setFlash( "success", $message );
      } else {
        \Yii::$app->session->setFlash( "error", $message );
      }
    }

  }

  /**
   * 设置成功结果
   * 尽量设置结果为数组
   *
   * @param string $view
   * @param mixed $data
   * @param string $message
   * @return array
   */
  public function renderSuccess( $view, $data, $message = '成功' ) {

    $status = "success";
    $this->setFlash( $status, $message );
    return compact( 'status', 'view', 'data', 'message' );

  }

  /**
   * 设置错误结果
   * 尽量设置结果为数组
   *
   * @param string $view
   * @param mixed $data
   * @param string $message
   * @return array
   */
  public function renderError( $view, $data, $message = '失败' ) {

    $status = "error";
    $this->setFlash( $status, $message );
    return compact( 'status', 'view', 'data', 'message' );

  }

  /**
   * 设置成功跳转
   *
   * @param string $redirectUrl
   * @param string $message
   * @return \yii\web\Response
   */
  public function redirectSuccess( $redirectUrl, $message = "成功" ) {

    $status = "success";
    $this->setFlash( $status, $message );
    return compact( 'status', 'redirectUrl', 'message' );

  }

  /**
   * 设置错误跳转
   *
   * @param string $url
   * @param string $message
   * @return \yii\web\Response
   */
  public function redirectError( $url, $message = "失败" ) {

    $status = "error";
    $this->setFlash( $status, $message );
    return compact( 'status', 'redirectUrl', 'message' );

  }

  /**
   * 重写默认的渲染方法，单是ajax请求的时候优先执行ajax渲染方法
   *
   * {@inheritdoc}
   * @see \yii\base\Controller::render()
   */
  public function render( $view, $params = [ ] ) {

    if ( \Yii::$app->request->isAjax ) {
      $result = parent::renderAjax( $view, $params );
    } else {
      $result = parent::render( $view, $params );
    }
    return $result;

  }
}
