<?php

use DuAdmin\Grids\MultilingualAction;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\FullSearchBox;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Addons\Cms\Models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t( 'da_cms_page', 'Pages' );
$this->params['breadcrumbs'][] = $this->title;
?>
<?php

Pjax::begin( [
    'id' => 'page-index'
] );
?>
<?php
PanelGridView::begin( [
    'id' => 'page-list',
    'intro' => Yii::t( 'da', '{0} Info Manage', Yii::t( 'da_cms_page', 'Pages' ) ),
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function ( $model, $key, $index, $column ) {
              return AppHelper::linkButtonWithSimpleModal( $model['title'], [
                  'view',
                  'id' => $model['id']
              ] );
            }
        ],
        'slug',
        [
            'class' => MultilingualAction::class,
            'openNewTab' => true,
            'controllerId' => '/cms/page-post',
            'formName' => 'PagePost',
            'forignKey' => 'pageId'
        ],
        [
            'class' => '\DuAdmin\Grids\ActionColumn'
        ]
    ]
] );
?>
<?=FullSearchBox::widget( [ 'action' => [ 'index']] )?>

<?=$this->render( '_search', [ 'model' => $searchModel] );?>

<?=AppHelper::linkButtonWithSimpleModal( '<i class="fa fa-plus"></i> ' . Yii::t( 'da', 'Create' ), [ 'create'], [ 'class' => 'btn btn-primary'] )?>

<?=Html::a( '<i class="fa fa-trash"></i> ' . Yii::t( 'da', 'Delete' ), [ 'delete'], [ 'class' => 'btn btn-danger del-all','data-target' => '#category-list'] )?>
<?php

PanelGridView::end()?>

<?php

Pjax::end();
?>

