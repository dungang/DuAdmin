<?php

use yii\helpers\Html;
use app\mmadmin\grids\PanelGridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\mmadmin\models\RewriteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'URL重写';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'rewrite-index']); ?>
<?php PanelGridView::begin([
    'id' => 'rewrites->list',
    'intro' => 'URL重写信息管理，主要是重写前端的url，后台不可以不用考虑',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => '\yii\grid\CheckboxColumn'],
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return Html::a($model['name'], ['view', 'id' => $model['id']], ['data-toggle' => 'modal', 'data-target' => '#modal-dailog']);
            }
        ],
        'name',
        'express',
        'route',
        [
            'class' => '\app\mmadmin\grids\ActionColumn',
            'buttonsOptions' => [
                'update' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-dailog',
                ],
                'view' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-dailog',
                ],
            ]
        ]
    ]
]); ?>
<?= Html::a('<i class="fa fa-plus"></i> 添加', ['create'], ['class' => 'btn btn-sm btn-link', 'data-toggle' => 'modal', 'data-target' => '#modal-dailog']) ?>
<?= Html::a('<i class="fa fa-trash"></i> 删除', ['delete'], ['class' => 'btn btn-sm btn-link del-all', 'data-target' => '#rewrites-list']) ?>
<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>

