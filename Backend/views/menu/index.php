<?php
use yii\helpers\Html;
use DuAdmin\Grids\PanelTreeGridView;
use DuAdmin\Widgets\PanelNavTabs;

/* @var $this yii\web\View */
/* @var $searchModel DuAdmin\Models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '导航';
$this->params['breadcrumbs'][] = $this->title;
PanelTreeGridView::begin([
    'intro' => '维护导航菜单，分前后端的菜单，目前只支持2级菜单。',
    'dataProvider' => $dataProvider,
    'keyColumnName' => 'id',
    'parentColumnName' => 'pid',
    'columns' => [
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return Html::a('<i class="' . $model['icon'] . '"></i> ' . Yii::t('app',$model['name']), [
                    'view',
                    'id' => $model['id']
                ], [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-dailog'
                ]);
            }
        ],
        'require_login',
        'url',
        'sort',
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
echo PanelNavTabs::widget([
    'wrapper' => true,
    'tabs' => [
        [
            'name' => '前台菜单',
            'url' => [
                '/menu/index',
                'MenuSearch[isFront]' => 1
            ]
        ],
        [
            'name' => '后台菜单',
            'url' => [
                '/menu/index',
                'MenuSearch[isFront]' => 0
            ]
        ],
        [
            'name' => '<i class="fa fa-plus"></i> 添加菜单',
            'url' => [
                'create',
                'Menu[isFront]' => $searchModel->isFront
            ],
            'options' => [
                'data-toggle' => 'modal',
                'data-target' => '#modal-dailog'
            ]
        ]
    ]
]);
?>
<?php PanelTreeGridView::end()?>
