<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use DuAdmin\Widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model Backend\Models\AuthPermissionSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php  \yii\bootstrap\Modal::begin([
        'id' => 'auth-permission-search-modal',
        'header' => '高级搜索',
        'toggleButton' => ['label'=>'<i class="fa fa-search"></i> 高级搜索','class'=>'btn btn-warning'],
    ]); ?>
<div class="auth-permission-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
                'data-pjax' => 1,
                'onsubmit' => "\$('#auth-permission-search-modal').modal('hide')"
        ],
    ]); ?>
<div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'id') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'name') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'ruleId') . '</div>' ?>

</div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i> ' .  Yii::t('da','Search'), ['class' => 'btn btn-warning']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php  Modal::end(); ?>
