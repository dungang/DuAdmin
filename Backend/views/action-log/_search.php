<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Backend\Models\ActionLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php  \yii\bootstrap\Modal::begin([
        'id' => 'action-log-search-modal',
        'header' => '高级搜索',
        'toggleButton' => ['label'=>'<i class="fa fa-search"></i> 高级搜索','class'=>'btn btn-warning'],
    ]); ?>
<div class="action-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
                'data-pjax' => 1,
                'onsubmit' => "\$('#action-log-search-modal').modal('hide')"
        ],
    ]); ?>
<div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'id') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'userId') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'action') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'ip') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'method') . '</div>' ?>

    <?php // echo '<div class="col-xs-6">' . $form->field($model, 'sourceType') . '</div>' ?>

    <?php // echo '<div class="col-xs-6">' . $form->field($model, 'createdAt')->widget('DuAdmin\Widgets\DatePicker',['multidate'=>2]) . '</div>' ?>

    <?php // echo '<div class="col-xs-6">' . $form->field($model, 'data')->widget('DuAdmin\Widgets\DefaultEditor') . '</div>' ?>

</div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i> ' .  Yii::t('da','Search'), ['class' => 'btn btn-warning']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php  Modal::end(); ?>