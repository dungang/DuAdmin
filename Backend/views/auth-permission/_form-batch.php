<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use Backend\Models\AuthRule;

/* @var $this \yii\web\View */
/* @var $models \Backend\Models\AuthPermission[] */

$form = ActiveForm::begin(['id' => 'auth-permission-batch-form', 'enableAjaxValidation' => false]);
$rules = AuthRule::allIdToName();
?>
<table id="batch-data-form" class="table" data-index="<?= count($models) ?>" data-target="tr">
    <tr>
        <th>ID</th>
        <th>PID</th>
        <th>名称</th>
        <th>规则</th>
        <td></td>
    </tr>
    <?php foreach ($models as $i => $model) : ?>
        <tr>
            <td><?= $form->field($model, "[$i]id")->label(false) ?></td>
            <td><?= $form->field($model, "[$i]pid")->label(false) ?></td>
            <td><?= $form->field($model, "[$i]name")->label(false) ?></td>
            <td><?= $form->field($model, "[$i]ruleId")->label(false)->dropDownList($rules) ?></td>
            <td width="90">
                <a href="javascript:void(0);" class="delete-self btn btn-sm btn-link"><i class="fa fa-trash text-danger"></i></a>
                <a href="javascript:void(0);" class="copy-self btn btn-sm btn-link"><i class="fa fa-plus"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="form-group">
    <?= Html::submitButton('<i class="fa fa-save"></i> 保存', ['class' => 'btn btn-success']) ?>
</div>
<?php
ActiveForm::end();
$this->registerJs("$('#batch-data-form').dynamicline()");
?>