<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '角色';
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin(['id'=>'role-index']);
PanelGridView::begin([
    'intro'=>'角色标识的一组权限标识的集合。一个用户可以拥有等于或者多余0个角色，从而获取不同的权限范围。',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'id',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return Html::a($model['id'], [
                    'view',
                    'id' => $model['id']
                ], [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-dailog'
                ]);
            }
        ],
        'name',
        'scope',
        'description',
        [
            'label' => '权限',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a('授权', [
                    'permission',
                    'name' => $model['name']
                ]);
            }
        ],

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
<?= Html::a('<i class="fa fa-plus"></i> 添加', ['create'], ['class' => 'btn btn-sm btn-default','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
<?php PanelGridView::end()?>
<?php Pjax::end()?>
