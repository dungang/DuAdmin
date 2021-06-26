<?php

namespace Addons\Ueditor\Widgets;

use Addons\Ueditor\Assets\UeditorAsset;
use DuAdmin\Widgets\DefaultEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;

class Ueditor extends DefaultEditor {

  public $serverUrl = [
      '/ueditor/upload/index'
  ];

  // 配置选项，参阅Ueditor官网文档(定制菜单等)
  public $clientOptions = [ ];

  /**
   *
   * @throws \yii\base\InvalidConfigException
   */
  public function init() {

    $this->id = $this->hasModel() ? Html::getInputId( $this->model, $this->attribute ) : $this->id;
    $this->id .= time();
    $options = [
        'serverUrl' => Url::to( $this->serverUrl ),
        'initialFrameWidth' => '100%',
        'initialFrameHeight' => '400',
        'autoFloatEnabled' => true,
        'topOffset' => 50,
        'lang' => (strtolower( \Yii::$app->language ) == 'en-us') ? 'en' : 'zh-cn'
    ];
    if ( \Yii::$app->request->isAjax ) {
      // 高于bootstrap modal的z-index=1050,否则工具栏对话框会被遮挡
      // 在模态框中打开一般会是ajax请求，异步加载
      $options['zIndex'] = 1060;
    }
    $baseBars = [
        'fullscreen',
        'source',
        'undo',
        'redo',
        '|',
        'fontsize',
        'bold',
        'italic',
        'underline',
        'fontborder',
        'strikethrough',
        'removeformat',
        'formatmatch',
        'autotypeset',
        'blockquote',
        'pasteplain',
        '|',
        'forecolor',
        'backcolor',
        '|',
        'lineheight',
        '|',
        'indent',
        '|'
    ];
    // $this->clientOptions['toolbars'] = [
    // array_merge( $baseBars, $this->getBars( $this->mode ) )
    // ];
    $this->clientOptions = ArrayHelper::merge( $options, $this->clientOptions );
    parent::init();

  }

  public function run() {

    $this->registerClientScript();
    if ( $this->hasModel() ) {
      return Html::activeTextarea( $this->model, $this->attribute, [
          'id' => $this->id
      ] );
    } else {
      return Html::textarea( $this->name, $this->value, [
          'id' => $this->id
      ] );
    }

  }

  /**
   * 注册客户端脚本
   */
  protected function registerClientScript() {

    $assets = UeditorAsset::register( $this->view );
    $this->clientOptions['UEDITOR_HOME_URL'] = $assets->baseUrl . '/';
    $clientOptions = Json::encode( $this->clientOptions );
    $script = "UE.delEditor('" . $this->id . "');UE.getEditor('" . $this->id . "', " . $clientOptions . ")";
    $this->view->registerJs( $script, View::POS_READY );

  }

  public function getBars( $mode = self::MODE_DEFAULT ) {

    if ( $mode === self::MODE_RICH ) {
      return [
          '|',
          'imagenone',
          'imageleft',
          'imageright',
          'imagecenter',
          '|',
          'insertimage',
          'insertvideo',
          '|',
          'map'
      ];
    } else {
      return [ ];
    }

  }
}
