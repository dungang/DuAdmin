<?php

use Addons\Cms\Assets\CmsAsset;
use Addons\Cms\Widgets\AdvBlockWidget;
use Addons\Cms\Widgets\PostCategories;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel Addons\Cms\Models\Post */
/* @var $category Addons\Cms\Models\Category */
/* @var $dataProvider yii\data\ActiveDataProvider */
CmsAsset::register( $this );
$this->title = isset( $category ) ? $category->name : '内容';
$this->params[ 'breadcrumbs' ][] = $this->title;
?>
<?= AdvBlockWidget::widget( [ 'nameCode' => 'post-list', 'urlPath' => \Yii::$app->request->getPathInfo() ] ) ?>
<div class="container">
    <div class="row ">
        <div class="col-md-8">
            <div class="cms-page">
                <?php
                echo ListView::widget( [
                    'layout'           => "{items}\n{pager}",
                    'dataProvider'     => $dataProvider,
                    'options'          => [
                        'class' => 'post-items list-view'
                    ],
                    'itemOptions'      => [
                        'class' => 'post-item'
                    ],
                    'renderBeforeItem' => function ( $model, $key, $index ) {
                        // 在列表最前面添加广告位
                        if ( $index == 0 ) {
                            return AdvBlockWidget::widget( [
                                    'nameCode' => 'cms-post-list'
                                ] );
                        } else {
                            return null;
                        }
                    },
                    'itemView' => function ( $model, $key, $index, $widget ) {
                        return $this->render( 'item-list-pic', [
                            'model' => $model
                        ] );
                    }
                ] );
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="cms-siderbar">
                <div class="panel panel-default">
                    <div class="panel-heading">栏目</div>
                    <div class="panel-body">
                        <?= PostCategories::widget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>