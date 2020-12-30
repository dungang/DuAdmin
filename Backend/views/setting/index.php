<?php
use DuAdmin\Grids\PanelGridView;
use yii\widgets\Pjax;
use DuAdmin\Widgets\PanelNavTabs;
use DuAdmin\Models\Setting;
use DuAdmin\Helpers\AppHelper;

/* @var $this yii\web\View */
/* @var $searchModel DuAdmin\Models\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::$app->controller->module->name . Yii::t('da', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin([
    'id' => 'setting-index'
]);
PanelGridView::begin([
    'intro' => '设置功能提高了系统的适应性，根据不同的场景和环境配置不同的变量值。',
    'dataProvider' => $dataProvider,
    'summary' => false,
    'columns' => [
        [
            'attribute' => 'title',
            'headerOptions' => [
                'width' => '200px'
            ],
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model['title'] . ' <i class="fa fa-question-circle-o" title="' . $model['hint'] . '" data-toggle="tooltip" data-placement="top" ></i>';
            }
        ],
        [
            'attribute' => 'value',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                $detail = AppHelper::linkButtonWithSimpleModal(Yii::t('da', 'View Detail'), [
                    'view',
                    'name' => $model['name']
                ]);
                return $model['valType'] === 'STR' ? (strlen($model['value']) < 128 ? $model['value'] : $detail) : $detail;
            }
        ],
        [
            'class' => '\DuAdmin\Grids\ActionColumn',
            'template' => '{view} {update}'
        ]
    ]
]);

if(\Yii::$app->controller->isBackend) {
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
    if (AppHelper::isDevMode()) {
        $tabs[] = [
            'name' => '<i class="fa fa-edit"></i> ' . Yii::t('da', 'Extend Category'),
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

PanelGridView::end()?>
<?php Pjax::end() ?>
