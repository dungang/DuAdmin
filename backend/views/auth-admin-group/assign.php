<?php
use app\kit\widgets\SelectBox;
use app\kit\widgets\AjaxModalOrNormalPanelContent;
use yii\helpers\Html;

$this->title = '权限分配组';
$this->params['breadcrumbs'][] = ['label' => '授权组', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
AjaxModalOrNormalPanelContent::begin([
    'intro' => '权限分配组',
]);
echo Html::beginForm(['assign','group_name'=>$group_name,'type'=>$type]);
echo SelectBox::widget([
    'boxOptions' => ['size' => 10],
    'name' => 'name[]',
    'sourceItems' => $unAssignedItems,
    'targetItems' => $assignedItems
]);
?>
<br/>
<div class="form-group">
    <?= Html::submitButton('<i class="fa fa-save"></i> 保存', ['class' => 'btn btn-success']) ?>
</div>
<?php
echo Html::endForm();
AjaxModalOrNormalPanelContent::end();
