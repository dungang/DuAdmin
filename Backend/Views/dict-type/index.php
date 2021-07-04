<?php

use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Widgets\FullSearchBox;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel DuAdmin\Models\DictTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t( 'app_dict_type', 'Dict Types' );
$this->params[ 'breadcrumbs' ][] = $this->title;
?>
<?php Pjax::begin( [ 'id' => 'dict-type-index' ] ); ?>
<?php

PanelGridView::begin( [
    'id'           => 'dict-type-list',
    'intro'        => Yii::t( 'da', '{0} Info Manage', Yii::t( 'app_dict_type', 'Dict Types' ) ),
    'dataProvider' => $dataProvider,
    'columns'      => [
        [ 'class' => '\DuAdmin\Grids\CheckboxColumn', 'name' => 'id' ],
        [
            'attribute' => 'id',
            'format'    => 'raw',
            'value'     => function ( $model, $key, $index, $column ) {
                return AppHelper::linkButtonWithSimpleModal( $model[ 'id' ], [ 'view',
                    'id' => $model[ 'id' ] ] );
            }
        ],
        'dictName',
        'dictType',
        [
            'label'  => '字典数据',
            'format' => 'raw',
            'value'  => function ( $model, $key, $index, $column ) {
                return Html::a( '管理', [ '/dict-data', 'dictType' => $model->dictType ] );
            }
        ],
        'status',
        'createdAt:date',
        //'updatedAt:date',
        [
            'class'     => '\DuAdmin\Grids\ActionColumn',
            'modalSize' => '',
            'template'  => '{view} {update} {delete}',
        ]
    ]
] );
?>

<?= FullSearchBox::widget( [ 'action' => [ 'index' ] ] ) ?>

<?= $this->render( '_search', [ 'model' => $searchModel ] ); ?>

<?=

AppHelper::linkButtonWithSimpleModal( '<i class="fa fa-plus"></i> ' . Yii::t( 'da', 'Create' ), [
    'create' ], [ 'class' => 'btn btn-primary' ] )
?>
<?=

Html::a( '<i class="fa fa-refresh"></i> ' . Yii::t( 'da', 'Refresh' ), [ 'index' ], [
    'class' => 'btn btn-info' ] )
?>

<?=

Html::a( '<i class="fa fa-trash"></i> ' . Yii::t( 'da', 'Delete' ), [ 'delete' ], [
    'class'       => 'btn btn-danger del-all', 'data-target' => '#dict-type-list' ] )
?>
<?php PanelGridView::end() ?>

<?php Pjax::end(); ?>

