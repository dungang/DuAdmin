<?php
use DuAdmin\Widgets\TreeSortableList;
use DuAdmin\Widgets\AdminltePanel;
use DuAdmin\UI\Row;
use DuAdmin\UI\Column;
use DuAdmin\UI\Box;
use yii\widgets\Pjax;
use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $models DuAdmin\Models\Menu[] */
/* @var $model DuAdmin\Models\Menu */

$this->title = Yii::t('backend', 'Auth Permissions');
$this->params['breadcrumbs'][] = $this->title;

Pjax::begin(['id'=>'auth-permission-index']); 
AdminltePanel::begin([
    'id' => 'auth-permission-tree',
    'intro' => Yii::t('da','{0} Info Manage',Yii::t('backend', 'Auth Permissions')),
    'content' => Row::widget([
        'children' => [
            Column::widget([
                'size' => 8,
                'children' => [
                    TreeSortableList::widget([
                        'maxDepth' => 3,
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
                        'title' => Yii::t('da', 'Create {0}', Yii::t('backend', 'Auth Permission')),
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

<?= AppHelper::linkButtonWithBigSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da','Batch Create'), ['batch-create'], ['class'=>'btn btn-primary', ]) ?>

<?= Html::a('<i class="fa fa-edit"></i> ' . Yii::t('da','Batch Update'), ['#'], [
        'data-url' => Url::to(['batch-update']),
        'class'=>'btn btn-success batch-update','data-modal-size' => 'modal-lg','data-target'=>'#auth-permission-list']) ?>

<?= Html::a('<i class="fa fa-refresh"></i> '. Yii::t('da','Refresh'), ['index'], ['class'=>'btn btn-info']) ?>

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#auth-permission-list']) ?>
<?php
AdminltePanel::end();
Pjax::end()?>