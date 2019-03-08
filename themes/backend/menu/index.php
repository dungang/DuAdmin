<?php
use yii\helpers\Html;
use app\kit\grids\PanelTreeGridView;
use app\kit\widgets\PanelNavTabs;

/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '导航';
$this->params['breadcrumbs'][] = $this->title;
PanelTreeGridView::begin([
    'panelTitle'=>'维护导航菜单',
    'dataProvider' => $dataProvider,
    'keyColumnName' => 'id',
    'parentColumnName' => 'pid',
    'columns' => [
        [
            'attribute' => 'id',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return Html::a('<i class="'. $model['icon'].'"></i> ' . $model['name'], [
                    'view',
                    'id' => $model['id']
                ], [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-dailog'
                ]);
            }
        ],
        'url:url',
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
echo PanelNavTabs::widget([
    'wrapper'=>true,
    'tabs' => [
        [
            'name' => '前台菜单',
            'url' => [
                '/backend/menu/index',
                'MenuSearch[is_front]' => 1
            ]
        ],
        [
            'name' => '后台菜单',
            'url' => [
                '/backend/menu/index',
                'MenuSearch[is_front]' => 0
            ]
        ],
        [
            'name' => '<i class="fa fa-plus"></i> 添加菜单',
            'url' => [
                'create',
                'Menu[is_front]' => $searchModel->is_front
            ],
            'options'=>['data-toggle'=>'modal','data-target'=>'#modal-dailog']
        ]
    ]
]);
?>
<?php PanelTreeGridView::end()?>
