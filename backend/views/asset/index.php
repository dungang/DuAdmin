<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\AssetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '代码资源文件';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'asset-index']); ?>
<?php

PanelGridView::begin(
    [
        'intro' => '代码资源文件信息管理',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'level',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model['name'], [
                        'view',
                        'id' => $model['id']
                    ], [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dailog'
                    ]);
                }
            ],
            'is_active:boolean',
            'baseUrl',
            [
                'class' => '\app\kit\grids\ActionColumn',
                'buttonsOptions' => [
                    'update' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dailog'
                    ],
                    'view' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dailog'
                    ]
                ]
            ]
        ]
    ]);
?>
<?= Html::a('<i class="fa fa-plus"></i> 添加', ['create'], ['class'=>'btn btn-sm btn-link','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>

