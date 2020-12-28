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
/* @var $models Backend\Models\AuthRole[] */
/* @var $model Backend\Models\AuthRole */

$this->title = Yii::t('app_auth_item', 'Auth Roles');
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin([
    'id' => 'tree-sort-role'
]);

AdminltePanel::begin([
    'id' => 'auth-role-tree',
    'intro' => Yii::t('da', '{0} Info Manage', Yii::t('app_auth_item', 'Auth Roles')),
    'content' => Row::widget([
        'children' => [
            Column::widget([
                'size' => 8,
                'children' => [
                    TreeSortableList::widget([
                        'maxDepth' => 1,
                        'items' => $models,
                        'actionColumn' => [
                            'template' => '{permissions}',
                            'buttons' => [
                                'permissions' => function ($url, $model, $key) {
                                    return AppHelper::linkButtonWithSimpleModal('<i class="fa fa-key"></i> ' . Yii::t('backend', 'Permissions'),['permissions','AuthRole[id]'=>$model['id']], [
                                        'class' => 'btn btn-link btn-xs'
                                    ]);
                                }
                            ]
                        ],
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