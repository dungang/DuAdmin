<?php

use Addons\Cms\Assets\CmsAsset;
use Addons\Cms\Helpers\CmsHelpers;
use Addons\Cms\Widgets\AdvBlockWidget;
use DuAdmin\Helpers\AppHelper;

/* @var $this yii\web\View */
/* @var $model \Addons\Cms\Models\Page */
$this->title = $model->title . '_' . Yii::t( 'app', AppHelper::getSetting( 'site.name' ) );
$this->params[ 'breadcrumbs' ] = null;
CmsAsset::register( $this );
$pagePost = $model->post;
CmsAsset::register( $this );
if ( $model->isLive ) {
    if ( $pagePost->content ) {
        CmsHelpers::registerBlockAssets( $pagePost->content );
        $pagePost->content = CmsHelpers::parseDynamicPageBlock( $pagePost->content );
    }
}
?>
<?= AdvBlockWidget::widget( ['nameCode' => 'page', 'urlPath' => \Yii::$app->request->getPathInfo()] ) ?>
<?= AppHelper::maxWidthImage( $pagePost->content ) ?>
