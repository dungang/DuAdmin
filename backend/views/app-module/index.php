<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\AppModuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '模块';
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin(['id'=>'app-module-index']);
PanelGridView::begin([
    'intro'=>'按照数据表对增删查改对路由分组，并对组规划权限标识。目的增强对路由和权限理解和规划。',
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn'
        ],
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return Html::a($model['name'], [
                    '/' . $model['name']
                ], [
                    'data-pjax' => '0'
                ]);
            }
        ],
        [
            'label' => '路由',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return Html::a('查看', [
                    '/backend/ac-route',
                    'parent' => $model['name'],
                    'title' => $model['description']
                ], [
                    'data-pjax' => '0'
                ]);
            }
        ],
        [
            'label' => '权限',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return Html::a('查看', [
                    '/backend/auth-permission',
                    'parent' => $model['name'],
                    'title' => $model['description']
                ], [
                    'data-pjax' => '0'
                ]);
            }
        ],
        [
            'class' => 'app\kit\grids\ActionColumn',
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
<?= Html::a('<i class="fa fa-plus"></i> 添加', ['create'], ['class' => 'btn btn-sm btn-default','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
<?php PanelGridView::end()?>
<?php Pjax::end()?>
