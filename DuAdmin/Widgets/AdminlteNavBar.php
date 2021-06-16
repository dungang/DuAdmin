<?php

namespace DuAdmin\Widgets;

use yii\bootstrap\Html;
use yii\bootstrap\Widget;

class AdminlteNavBar extends Widget {

  public $options = [ ];

  public $headerClass = 'main-header';

  public $logoUrl = '';

  public $logoMiniLabel = 'DA';

  public $logoLargeLabel = 'DuAdmin';

  public $navClass = 'navbar navbar-static-top';

  public function init() {

    parent::init();
    if (! isset( $this->options ['id'] )) {
      $this->options ['id'] = $this->getId();
    }
    ob_start();
    ob_implicit_flush( false );

  }

  public function run() {

    $content = ob_get_clean();
    $logoLabels = Html::tag( 'span', $this->logoMiniLabel, [
        'class' => 'logo-mini'
    ] ) . Html::tag( 'span', $this->logoLargeLabel, [
        'class' => 'logo-lg'
    ] );
    $logo = Html::a( $logoLabels, '#', [
        'class' => 'logo'
    ] );
    $toggleButton = Html::a( '<span class="sr-only">Toggle navigation</span>', '#', [
        'class' => 'sidebar-toggle',
        'data-toggle' => "push-menu",
        'role' => "button"
    ] );
    $navbar = Html::tag( 'div', $toggleButton . $content, [
        'class' => $this->navClass
    ] );
    return Html::tag( 'header', $logo . $navbar, [
        'class' => $this->headerClass
    ] );

  }
}

