<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Backend\Models\AdminSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php  \yii\bootstrap\Modal::begin([
        'id' => 'admin-search-modal',
        'header' => '高级搜索',
        'toggleButton' => ['label'=>'<i class="fa fa-search"></i> 高级搜索','class'=>'btn btn-warning'],
    ]); ?>
<div class="admin-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
                'data-pjax' => 1,
                'onsubmit' => "\$('#admin-search-modal').modal('hide')"
        ],
    ]); ?>
<div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'id') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'username') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'nickname') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'avatar') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'authKey') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'passwordHash') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'passwordResetToken') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'email') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'mobile') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'status')->dropDownList([ 0 => '未激活', 10 => '已激活', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'isSuper')->dropDownList([ '普通成员', '超级管理员', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'loginAt')->widget('DuAdmin\Widgets\DatePicker',['multidate'=>2]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'loginFailure') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'loginIp') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'createdAt')->widget('DuAdmin\Widgets\DatePicker',['multidate'=>2]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'updatedAt')->widget('DuAdmin\Widgets\DatePicker',['multidate'=>2]) . '</div>' ?>

</div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i> ' .  Yii::t('da','Search'), ['class' => 'btn btn-warning']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php  Modal::end(); ?>