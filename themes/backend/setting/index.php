<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;
use app\kit\widgets\PanelNavTabs;
use app\kit\models\Setting;

/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '系统设置';
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin([
    'id' => 'menu-index'
]);
PanelGridView::begin([
    'intro' => '设置功能提高了系统的适应性，根据不同的场景和环境配置不同的变量值。',
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

$categories = Setting::getSettingCatetory();
$tabs = [];
foreach ($categories as $key => $title) {
    $tabs[] = [
        'name' => $title,
        'url' => [
            '/backend/setting/index',
            'SettingSearch[category]' => $key
        ]
    ];
}
$tabs[] = [
    'name' => '<i class="fa fa-edit"></i> 扩展分类',
    'url' => [
        'update',
        'name' => 'setting.category'
    ],
    'options' => [
        'data-toggle' => 'modal',
        'data-target' => '#modal-dailog'
    ]
];
$tabs[] = [
    'name' => '<i class="fa fa-plus"></i> 添加设置',
    'url' => [
        'create',
        'Setting[category]' => $searchModel->category
    ],
    'options' => [
        'data-toggle' => 'modal',
        'data-target' => '#modal-dailog'
    ]
];

echo PanelNavTabs::widget([
    'wrapper' => true,
    'tabs' => $tabs
]);
PanelGridView::end()?>
<?php Pjax::end()?>
