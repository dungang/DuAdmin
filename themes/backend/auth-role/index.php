<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;

/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '角色';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
PanelGridView::begin([
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
<p>
    <?= Html::a('添加角色', ['create'], ['class' => 'btn btn-success','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
</p>
<?php PanelGridView::end()?>
