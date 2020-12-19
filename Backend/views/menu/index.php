<?php
use DuAdmin\Widgets\TreeSortableList;
use DuAdmin\Widgets\AdminltePanel;
use DuAdmin\UI\Row;
use DuAdmin\UI\Column;
use DuAdmin\Models\Menu;
use DuAdmin\UI\Box;
use yii\widgets\Pjax;
use DuAdmin\Widgets\PanelNavTabs;

/* @var $this yii\web\View */
/* @var $models DuAdmin\Models\Menu[] */
/* @var $model DuAdmin\Models\Menu */

$this->title = '导航';
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin([
    'id' => 'tree-sort-menu'
]);

AdminltePanel::begin([
    'intro' => '维护导航菜单，分前后端的菜单，目前只支持2级菜单。',
    'content' => Row::widget([
        'children' => [
            Column::widget([
                'size' => 8,
                'children' => [
                    TreeSortableList::widget([
                        'items' => $models,
                        'rowRender' => function ($item) {
                            $content = '<i class="' . $item['icon'] . '"></i> ' . $item['name'];
                            if (empty($item['requireLogin'])) {
                                $content .= ' <span class="label label-primary label-xs">访客</span>';
                            }
                            return $content;
                        }
                    ])
                ]
            ]),
            Column::widget([
                'size' => 4,
                'children' => [
                    Box::widget([
                        'enableAjaxForm' => true,
                        'title' => Yii::t('da', 'Create {0}', Yii::t('backend', 'Menu')),
                        'children' => [
                            $this->render('_form', [
                                'model' => $model,
                                'action' => [
                                    'create'
                                ]
                            ])
                        ]
                    ])
                ]
            ])
        ]
    ])
]);
echo PanelNavTabs::widget([
    'wrapper' => true,
    'tabs' => [
        [
            'name' => '前台菜单',
            'url' => [
                'index',
                'Menu[isFront]' => 1
            ]
        ],
        [
            'name' => '后台菜单',
            'url' => [
                'index',
                'Menu[isFront]' => 0
            ]
        ]
    ]
]);
AdminltePanel::end();
Pjax::end()?>