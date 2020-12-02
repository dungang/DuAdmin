<?php
use yii\helpers\Html;
use DuAdmin\Grids\PanelGridView;
use yii\widgets\Pjax;
use DuAdmin\Widgets\PanelNavTabs;
use Backend\Models\AuthGroup;

/* @var $this yii\web\View */
/* @var $searchModel Backend\Models\AuthItemSearch */
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
        'description',
        'group_name',
        [
            'label' => '权限',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a('授权', [
                    'permission',
                    'name' => $model['name'],
                    'group_name' => $model['group_name']
                ]);
            }
        ],

        [
            'class' => '\DuAdmin\Grids\ActionColumn',
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
$tabs = array_map(function($group){
    return [
        'name'=>$group['title'],
        'url' => [
            'index',
            'AuthRoleSearch[group_name]' => $group['name']
        ]
    ];
},AuthGroup::findAll(['type'=>AuthGroup::TYPE_ROLE]));
array_push($tabs,[
    'name' => '<i class="fa fa-plus"></i> 添加角色',
    'url' => [
        'create',
        'AuthRole[group_name]' => $searchModel->group_name,
    ],
    'options'=>['data-toggle'=>'modal','data-target'=>'#modal-dailog']
]);
echo PanelNavTabs::widget([
    'wrapper'=>true,
    'tabs' => $tabs
]);   
?>
<?php PanelGridView::end()?>
<?php Pjax::end()?>
