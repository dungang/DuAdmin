<?php
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\FullSearchBox;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel DuAdmin\Models\PageBlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t( 'app_page_block', 'Page Blocks' );
$this->params ['breadcrumbs'] [] = $this->title;
?>
<?php
Pjax::begin( [
    'id' => 'page-block-index'
] );
?>
<?php
PanelGridView::begin( [
    'id' => 'page-block-list',
    'intro' => Yii::t( 'da', '{0} Info Manage', Yii::t( 'app_page_block', 'Page Blocks' ) ),
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => '\DuAdmin\Grids\CheckboxColumn',
            'name' => 'id'
        ],
        [
            'attribute' => 'id',
            'format' => 'raw',
            'value' => function ( $model, $key, $index, $column ) {
              return AppHelper::linkButtonWithSimpleModal( $model ['id'], [
                  'view',
                  'id' => $model ['id']
              ] );
            }
        ],
        'name',
        'widget',
        'sourceApp',
        'createdAt:date',
        // 'updatedAt:date',
        [
            'class' => '\DuAdmin\Grids\ActionColumn',
            'modalSize' => '',
            'template' => '{view} {update} {delete}'
        ]
    ]
] );
?>

<?=FullSearchBox::widget( [ 'action' => [ 'index']] )?>

<?=$this->render( '_search', [ 'model' => $searchModel] );?>

<?=AppHelper::linkButtonWithSimpleModal( '<i class="fa fa-plus"></i> ' . Yii::t( 'da', 'Create' ), [ 'create'], [ 'class' => 'btn btn-primary'] )?>
<?=Html::a( '<i class="fa fa-refresh"></i> ' . Yii::t( 'da', 'Refresh' ), [ 'index'], [ 'class' => 'btn btn-info'] )?>

<?=Html::a( '<i class="fa fa-trash"></i> ' . Yii::t( 'da', 'Delete' ), [ 'delete'], [ 'class' => 'btn btn-danger del-all','data-target' => '#page-block-list'] )?>
<?php
PanelGridView::end()?>

<?php
Pjax::end();
?>

