<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\AppModuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '系统模块';
$this->params['breadcrumbs'][] = $this->title;
PanelGridView::begin([
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
                    '/backend/' . $model['name']
                ], [
                    'data-pjax' => '0'
                ]);
            }
        ],
        'description:ntext',
        'created_at:date',
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
<p>
    <?= Html::a('添加模块', ['create'], ['class' => 'btn btn-success','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
</p>
<?php PanelGridView::end()?>
