<?php
use DuAdmin\Widgets\TreeSortableList;
use DuAdmin\Widgets\AdminltePanel;
use DuAdmin\UI\Row;
use DuAdmin\UI\Column;
use DuAdmin\UI\Box;
use yii\widgets\Pjax;
use DuAdmin\Helpers\AppHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $models DuAdmin\Models\Menu[] */
/* @var $model DuAdmin\Models\Menu */

$this->title = Yii::t('backend', 'Auth Roles');
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin([
    'id' => 'tree-sort-role'
]);

AdminltePanel::begin([
    'id' => 'auth-role-tree',
    'intro' => Yii::t('da','{0} Info Manage',Yii::t('backend', 'Auth Roles')),
    'content' => Row::widget([
        'children' => [
            Column::widget([
                'size' => 8,
                'children' => [
                    TreeSortableList::widget([
                        'maxDepth' => 1,
                        'items' => $models,
                        'rowRender' => function ($item) {
                            $content = $item['name'];
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
                        'title' => Yii::t('da', 'Create {0}', Yii::t('backend', 'Auth Role')),
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
?>

<?= AppHelper::linkButtonWithSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary']) ?>

<?= Html::a('<i class="fa fa-refresh"></i> '. Yii::t('da','Refresh'), ['index'], ['class'=>'btn btn-info']) ?>

<?php 
AdminltePanel::end();
Pjax::end()?>