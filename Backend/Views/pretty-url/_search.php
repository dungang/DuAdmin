<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\PrettyUrlSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
 
	$searchText = Yii::t('da','Advanced Search');
	\yii\bootstrap\Modal::begin([
        'id' => 'pretty-url-search-modal',
        'header' => $searchText,
        'toggleButton' => ['label'=>'<i class="fa fa-search"></i> ' . $searchText,'class'=>'btn btn-warning'],
    ]); ?>
<div class="pretty-url-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
                'data-pjax' => 1,
                'onsubmit' => "\$('#pretty-url-search-modal').modal('hide')"
        ],
    ]); ?>
<div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'id') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'name') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'express') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'weight') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'route') . '</div>' ?>

</div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i> ' .  Yii::t('da','Search'), ['class' => 'btn btn-warning']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php  Modal::end(); ?>
