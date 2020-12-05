<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $models Backend\Models\AuthGroup[] */

$this->title = '批量添加';
$this->params['breadcrumbs'][] = ['label' => '授权组', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
AjaxModalOrNormalPanelContent::begin([
    'intro' => '批量添加授权组信息',
]);
$form = ActiveForm::begin(['id' => 'auth-group-batch-form', 'enableAjaxValidation' => false]);
?>
<table id="data-form" class="table" data-index="<?=count($models)?>" data-target="tr">
    <tr>
        <th>类型</th>
        <th>编码</th>
        <th>类型</th>
        <th>后端</th>
        <td></td>
    </tr>
    <?php foreach ($models as $i => $model) : ?>
        <tr>
            <td><?= $form->field($model, "[$i]isBackend")->label(false)->dropDownList([
                0=>'否',
                1=>'是'
            ]) ?></td>
            <td><?= $form->field($model, "[$i]title")->label(false) ?></td>
            <td><?= $form->field($model, "[$i]name")->label(false) ?></td>
            <td><?= $form->field($model, "[$i]type")->label(false)->dropDownList(['1' => '角色', '2' => '权限']) ?></td>
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
AjaxModalOrNormalPanelContent::end();
$this->registerJs("$('#data-form').dynamicline()");
?>