<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\mmadmin\widgets\AjaxModalOrNormalPanelContent;
use app\mmadmin\widgets\ZTree;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\mmadmin\models\AuthRole */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $rights array*/

$this->title = '角色授权';
$this->params['breadcrumbs'][] = [
    'label' => '角色',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => [
        'view',
        'id' => $model->name
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-role-permissions">
    <?php ActiveForm::begin(); ?>
    <?php
    AjaxModalOrNormalPanelContent::begin([
        'intro' => '给角色<strong>' . $model->name . '</strong>分配权限标识',
    ]);

    $zTreeSettings = [
        'callback' => [
            'onCheck' => new JsExpression("function(event,treeId,treeNode){
                var treeObj = this.getZTreeObj(treeId);
                var nodes = treeObj.getCheckedNodes(true);
                var rights = new Array();
                for(var p in nodes){
                    rights.push(nodes[p].id);
                }
                $('#permission_rights').val(rights.join(','));
            }")
        ],
        'view' => [
            'showIcon' => false
        ],
        'check' => [
            'enable' => true
        ]
    ];
    ?>
    <p>
        <?= Html::submitButton('<i class="fa fa-save"></i> 保存', ['class' => 'btn btn-sm btn-default']) ?>
    </p>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">权限</h3>
                    <?= Html::hiddenInput('permission[]', implode(',', $permission_rights), ['id' => 'permission_rights']) ?>
                </div>
                <div id="permission-tree" class="box-body ztree">
                    <?php ZTree::widget([
                        'id' => 'permission-tree',
                        'settings' => $zTreeSettings,
                        'nodes' => $permissions,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">角色</h3>
                    <?= Html::hiddenInput('permission[]', implode(',', $role_rights), ['id' => 'role_rights']) ?>
                </div>
                <div id="role-tree" class="box-body ztree">
                    <?php ZTree::widget([
                        'id' => 'role-tree',
                        'settings' => $zTreeSettings,
                        'nodes' => $roles,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <?php AjaxModalOrNormalPanelContent::end() ?>

    <?php ActiveForm::end(); ?>
</div>