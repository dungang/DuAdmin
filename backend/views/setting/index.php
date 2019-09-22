<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;
use app\kit\widgets\PanelNavTabs;
use app\kit\models\Setting;

/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::$app->controller->module->name . '设置';
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin([
    'id' => 'setting-index'
]);
PanelGridView::begin(
    [
        'intro' => '设置功能提高了系统的适应性，根据不同的场景和环境配置不同的变量值。',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            [
                'attribute' => 'value',
                'format'=>'raw',
                'value' => function ($model, $key, $index, $column) {
                    $detail =  Html::a('查看详情', [
                        'view',
                        'name' => $model['name']
                    ], [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dailog'
                    ]);
                    return $model['val_type']=='STR'
                        ?(strlen($model['value'])<128?$model['value']:$detail ):$detail;
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

if (\Yii::$app->controller->is_backend_module) {
    $tabs = [];
    $categories = Setting::getSettingCatetory();
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
} else {
    echo Html::a('<i class="fa fa-plus"></i> 添加设置', [
        'create',
        'Setting[category]' => $searchModel->category
    ], [
        'data-toggle' => 'modal',
        'data-target' => '#modal-dailog'
    ]);
}

PanelGridView::end()?>
<?php Pjax::end()?>
