<?php
use DuAdmin\Widgets\TreeSortableList;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $models \Backend\Models\AuthPermission[] */
/* @var $model \Backend\Models\AuthPermission */
/* @var $role \Backend\Models\AuthRole */

$this->title = Yii::t('app_auth_item', 'Auth Permissions');
$this->params['breadcrumbs'][] = $this->title;
echo Html::beginForm([
    'assignment',
    'parent' => $role->id
],'post',['id'=>'role-assignment-permissions']);
AjaxModalOrNormalPanelContent::begin([
    'id' => 'auth-permission-tree',
    'intro' => Yii::t('da', '{0} Info Manage', Yii::t('app_auth_item', 'Auth Permissions')),
    'content' => TreeSortableList::widget([
        'maxDepth' => 4, // 1插件（Menu）/2控制器（Manage）/3行为（update）/4同权限行为（sorts）
        'items' => $models,
        'checkName' => 'permission',
        'enableSortable' => false,
        'actionColumn' => false,
        'rowRender' => function ($item) {
            $content = $item['name'];
            return $content;
        }
    ])
]);
?>
<div class="form-group">
<?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da', 'Save'), ['class' => 'btn btn-success']) ?>
</div>
<?php
AjaxModalOrNormalPanelContent::end();
echo Html::endForm();
?>