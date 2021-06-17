<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\NavigationSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php  \yii\bootstrap\Modal::begin([
        'id' => 'navigation-search-modal',
        'header' => '高级搜索',
        'toggleButton' => ['label'=>'<i class="fa fa-search"></i> 高级搜索','class'=>'btn btn-warning'],
    ]); ?>
<div class="navigation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
                'data-pjax' => 1,
                'onsubmit' => "\$('#navigation-search-modal').modal('hide')"
        ],
    ]); ?>
<div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'id') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'pid') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'name') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'url') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'requireLogin')->dropDownList([ '不需要', '需要', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'icon') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'app') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'sort') . '</div>' ?>

</div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i> ' .  Yii::t('da','Search'), ['class' => 'btn btn-warning']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php  Modal::end(); ?>
