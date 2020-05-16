<?php

use yii\helpers\Html;
use app\mmadmin\grids\PanelGridView;
use app\mmadmin\helpers\MAHelper;
use yii\widgets\Pjax;
use app\mmadmin\widgets\PanelNavTabs;
use app\mmadmin\models\Setting;

/* @var $this yii\web\View */
/* @var $searchModel app\mmadmin\models\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::$app->controller->module->name . Yii::t('ma', 'Settings');
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
                'label' => Yii::t('ma', 'Translation'),
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return MAHelper::translation_link('backend', $model->title);
                }
            ],
            [
                'attribute' => 'value',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    $detail =  Html::a(Yii::t('ma', 'View Detail'), [
                        'view',
                        'name' => $model['name']
                    ], [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dailog'
                    ]);
                    return $model['val_type'] == 'STR'
                        ? (strlen($model['value']) < 128 ? $model['value'] : $detail) : $detail;
                }
            ],
            [
                'label' => Yii::t('ma', 'Translation'),
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return MAHelper::translation_link('app', $model->value);
                }
            ],
            [
                'class' => '\app\mmadmin\grids\ActionColumn',
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
    ]
);

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
        'name' => '<i class="fa fa-edit"></i> ' . Yii::t('ma', 'Extend Category'),
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
        'name' => '<i class="fa fa-plus"></i> ' . Yii::t('ma', 'Create'),
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
    echo Html::a('<i class="fa fa-plus"></i> ' . Yii::t('ma', 'Create'), [
        'create',
        'Setting[category]' => $searchModel->category
    ], [
        'data-toggle' => 'modal',
        'data-target' => '#modal-dailog'
    ]);
}

PanelGridView::end() ?>
<?php Pjax::end() ?>
