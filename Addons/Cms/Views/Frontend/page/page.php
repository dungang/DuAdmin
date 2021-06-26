<?php
use Addons\Cms\Assets\CmsAsset;
use Addons\Cms\Widgets\AdvBlockWidget;
use DuAdmin\Helpers\AppHelper;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model \Addons\Cms\Models\Page */
$this->title = $model->title . '_' . Yii::t( 'app', AppHelper::getSetting( 'site.name' ) );
$this->params['breadcrumbs'][] = $model->title;
CmsAsset::register( $this );
?>
<?=AdvBlockWidget::widget( [ 'nameCode' => 'page','urlPath' => \Yii::$app->request->getPathInfo()] )?>
<div class="container">
    <div class="cms-page">
        <div class="cms-post">

            <h1><?=Html::encode( $model->post->title )?></h1>
            <p class="text-center text-muted">
            </p>
            <div class="cms-post-content text-justify">
                 <?=AppHelper::maxWidthImage( $model->post->content )?>
            </div>

        </div>
    </div>
</div>