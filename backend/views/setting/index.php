<?php

use yii\helpers\Html;
use DuAdmin\Grids\PanelGridView;
use yii\widgets\Pjax;
use DuAdmin\Widgets\PanelNavTabs;
use DuAdmin\Models\Setting;

/* @var $this yii\web\View */
/* @var $searchModel DuAdmin\Models\SettingSearch */
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
        'columns' => [
            [
                'attribute'=>'title',
                'headerOptions'=>['width'=>'200px'],
                'format' => 'raw',
                'value' => function($model,$key,$index,$column){
                    return $model['title'] . 
                    ' <i class="fa fa-question-circle-o" title="'. $model['hint'] .'" data-toggle="tooltip" data-placement="top" ></i>';
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
                'class' => '\DuAdmin\Grids\ActionColumn',
                'template' => '{view} {update}',
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
                '/setting/index',
                'SettingSearch[category]' => $key
            ]
        ];
    }
    if(defined('YII_ENV') && YII_ENV == 'dev') {
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
    }
    echo PanelNavTabs::widget([
        'wrapper' => true,
        'tabs' => $tabs
    ]);
}

PanelGridView::end() ?>
<?php Pjax::end() ?>
