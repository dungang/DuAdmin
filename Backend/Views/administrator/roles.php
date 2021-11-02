<?php

use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;
use DuAdmin\Widgets\TreeSortableList;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $models Backend\Models\AuthRole[] */
/* @var $model Backend\Models\AuthRole */
/* @var $admin Backend\Models\Admin */
/* @var $userId int */

$this->title = Yii::t('app_auth_role', 'Auth Roles');
$this->params['breadcrumbs'][] = $this->title;
echo Html::beginForm([
  'assignment-roles',
  'userId' => $userId
], 'post', [
  'id' => 'admin-assignment-roles'
]);
AjaxModalOrNormalPanelContent::begin([
  'id' => 'auth-role-tree',
  'intro' => Yii::t('da', '{0} Info Manage', Yii::t('app_auth_role', 'Auth Roles')),
  'content' => TreeSortableList::widget([
    'maxDepth' => 1,
    'items' => $models,
    'checkName' => 'role',
    'enableSortable' => false,
    'actionColumn' => false,
    'rowRender' => function ($item) {
      $content = $item['name'];
      return $content;
    }
  ])
]);
if ($models) :
?>
  <div class="form-group">
    <?= Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('da', 'Save'), ['class' => 'btn btn-success']) ?>
  </div>
<?php
endif;

AjaxModalOrNormalPanelContent::end();
echo Html::endForm();
?>