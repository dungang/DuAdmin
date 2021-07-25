<?php

use Addons\Cms\Assets\CmsAsset;
use Addons\Cms\Widgets\AdvBlockWidget;
use DuAdmin\Helpers\AppHelper;

/* @var $this yii\web\View */
/* @var $model \Addons\Cms\Models\Page */
$this->title = $model->title . '_' . Yii::t( 'app', AppHelper::getSetting( 'site.name' ) );
$this->params[ 'breadcrumbs' ] = null;
CmsAsset::register( $this );
?>
<?= AdvBlockWidget::widget( ['nameCode' => 'page', 'urlPath' => \Yii::$app->request->getPathInfo()] ) ?>
<?= AppHelper::maxWidthImage( $model->post->content ) ?>
