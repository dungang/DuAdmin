<?php
use yii\helpers\Html;
use DuAdmin\Grids\PanelGridView;
use Backend\Models\AuthGroup;

/* @var $this yii\web\View */
/* @var $searchModel Backend\Models\AuthPermissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$group = AuthGroup::findOne(['name' => $searchModel->group_name]);
$this->title = $group->title;
$this->params['breadcrumbs'][] = [
    'label' => '管理员权限组',
    'url' => ['index', 'AuthGroupSearch[type]' => $searchModel->type]
];
$this->params['breadcrumbs'][] = $this->title;
PanelGridView::begin([
    'intro' => $group->title . '组分配的权限。',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn'
        ],
        'name',
        'description:ntext',
    ]
]);
?>
<?= Html::a(
    '<i class="fa fa-plus"></i> 添加',
    [
        'assign',
        'group_name' => $searchModel->group_name,
        'type' => $searchModel->type,
    ],
    ['class' => 'btn btn-sm btn-default', 'data-toggle' => 'modal', 'data-modal-size' => 'modal-lg', 'data-target' => '#modal-dailog']
) ?>
<?php PanelGridView::end() ?>
