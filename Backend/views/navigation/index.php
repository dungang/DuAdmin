<?php
use yii\widgets\Pjax;
use DuAdmin\Widgets\AdminltePanel;
use DuAdmin\UI\Column;
use DuAdmin\UI\Box;
use DuAdmin\Widgets\TreeSortableList;
use DuAdmin\UI\Row;
/* @var $this yii\web\View */
/* @var $models DuAdmin\Models\Navigation[] */
/* @var $model DuAdmin\Models\Navigation */

$this->title = Yii::t('backend', 'Navigations');
$this->params['breadcrumbs'][] = $this->title;

Pjax::begin(['id'=>'navigation-index']); 
echo AdminltePanel::widget([
    'id' => 'navigation-list',
    'intro' => Yii::t('da', '{0} Info Manage', Yii::t('backend', 'Navigations')),
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
                                $content .= ' <span class="label label-danger label-xs">不用登录</span>';
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