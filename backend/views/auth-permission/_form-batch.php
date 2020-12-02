<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $models \Backend\Models\AuthPermission[] */

$form = ActiveForm::begin(['id' => 'auth-permission-batch-form', 'enableAjaxValidation' => false]);
?>
<table id="batch-data-form" class="table" data-index="<?= count($models) ?>" data-target="tr">
    <tr>
        <th>名称</th>
        <th>子权限</th>
        <th>描述</th>
        <th>规则</th>
        <td></td>
    </tr>
    <?php foreach ($models as $i => $model) : ?>
        <tr>
            <td><?= $form->field($model, "[$i]name")->label(false) ?></td>
            <td><?= $form->field($model, "[$i]child")->label(false) ?></td>
            <td><?= $form->field($model, "[$i]description")->label(false) ?></td>
            <td><?= $form->field($model, "[$i]rule_name")->label(false) ?></td>
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