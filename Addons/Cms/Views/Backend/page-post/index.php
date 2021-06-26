<?php
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\FullSearchBox;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Addons\Cms\Models\PagePostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t( 'da_page_post', 'Page Posts' );
$this->params['breadcrumbs'][] = $this->title;
?>
<?php

Pjax::begin( [
    'id' => 'page-post-index'
] );
?>
<?php

PanelGridView::begin( [
    'id' => 'page-post-list',
    'intro' => Yii::t( 'da', '{0} Info Manage', Yii::t( 'da_page_post', 'Page Posts' ) ),
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => '\DuAdmin\Grids\CheckboxColumn',
            'name' => 'id'
        ],
        [
            'attribute' => 'pageId',
            'format' => 'raw',
            'value' => function ( $model, $key, $index, $column ) {
              return AppHelper::linkButtonWithSimpleModal( $model['pageId'], [
                  'view',
                  'id' => $model['pageId']
              ] );
            }
        ],
        'template',
        'language',
        'title',
        'content:ntext',
        'createdAt:date',
        // 'updatedAt:date',
        [
            'class' => '\DuAdmin\Grids\ActionColumn'
        ]
    ]
] );
?>

<?=FullSearchBox::widget( [ 'action' => [ 'index']] )?>

<?=$this->render( '_search', [ 'model' => $searchModel] );?>

<?=AppHelper::linkButtonWithSimpleModal( '<i class="fa fa-plus"></i> ' . Yii::t( 'da', 'Create' ), [ 'create'], [ 'class' => 'btn btn-primary'] )?>

<?=Html::a( '<i class="fa fa-refresh"></i> ' . Yii::t( 'da', 'Refresh' ), [ 'index'], [ 'class' => 'btn btn-info'] )?>

<?=Html::a( '<i class="fa fa-trash"></i> ' . Yii::t( 'da', 'Delete' ), [ 'delete'], [ 'class' => 'btn btn-danger del-all','data-target' => '#page-post-list'] )?>
<?php

PanelGridView::end()?>

<?php

Pjax::end();
?>

