<?php

use yii\helpers\Html;
use DuAdmin\Grids\PanelGridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel DuAdmin\Models\RewriteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'URL重写';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'rewrite-index']); ?>
<?php PanelGridView::begin([
    'id' => 'pretty-url-list',
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
            'class' => '\DuAdmin\Grids\ActionColumn',
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
<?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('ma','Create'), ['create'], ['class'=>'btn btn-primary','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('ma','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#pretty-url-list']) ?>

<?=DuAdmin\Widgets\FullSearchBox::widget(['action'=>['index']]) ?>
<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>

