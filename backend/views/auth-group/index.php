<?php

use yii\helpers\Html;
use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;
use app\kit\widgets\PanelNavTabs;

/* @var $this yii\web\View */
/* @var $searchModel app\backend\models\AuthGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '授权组';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'auth-group-index']); ?>
<?php PanelGridView::begin([
    'intro' => '授权组信息管理，对权限验证没有任何的影响，只是为了优化维护授权的过程',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return Html::a($model['title'], ['view', 'id' => $model['name']], ['data-toggle' => 'modal', 'data-target' => '#modal-dailog']);
            }
        ],
        'name',
        'is_backend:boolean',
        [
            'class' => 'app\kit\grids\FilterColumn',
            'attribute' => 'type',
            'filter' => ['1' => '角色', '2' => '权限']
        ],
        [
            'label' => '权限',
            'format' => 'raw',
            'value' => function ($model, $key, $index) {
                return Html::a(
                    '分配',
                    [
                        'permission',
                        'AuthPermissionSearch[group_name]' => $model['name'],
                        'AuthPermissionSearch[type]' => $model['type']
                    ],
                    [
                        'data-pjax' => '0'
                    ]
                );
            }
        ],
        [
            'class' => '\app\kit\grids\ActionColumn',
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
]);
echo PanelNavTabs::widget([
    'wrapper' => true,
    'tabs' => [
        [
            'name' => '角色组',
            'url' => [
                'index',
                'AuthGroupSearch[type]' => 1
            ]
        ],
        [
            'name' => '权限组',
            'url' => [
                'index',
                'AuthGroupSearch[type]' => 2
            ]
        ],
        [
            'name' => '<i class="fa fa-plus"></i> 添加组',
            'url' => [
                'create',
                'AuthGroup[type]' => $searchModel->type
            ],
            'options' => ['data-toggle' => 'modal', 'data-target' => '#modal-dailog']
        ],
        [
            'name' => '<i class="fa fa-plus"></i> 批量添加组',
            'url' => [
                'batch-create',
                'AuthGroup[type]' => $searchModel->type
            ],
            'options' => ['data-toggle' => 'modal', 'data-modal-size' => 'modal-lg', 'data-target' => '#modal-dailog']
        ]
    ]
]);
?>
<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>

