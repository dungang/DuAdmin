<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;

/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '系统设置';
$this->params['breadcrumbs'][] = $this->title;

PanelGridView::begin([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'title',
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return Html::a($model['name'], [
                    'view',
                    'id' => $model['name']
                ], [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-dailog'
                ]);
            }
        ],
        'value:ntext',

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
    <?= Html::a('添加', ['create'], ['class' => 'btn btn-success','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
</p>
<?php PanelGridView::end()?>
