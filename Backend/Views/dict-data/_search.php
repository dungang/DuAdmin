<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use DuAdmin\Widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\DictDataSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
 
	$searchText = Yii::t('da','Advanced Search');
	\yii\bootstrap\Modal::begin([
        'id' => 'dict-data-search-modal',
        'header' => $searchText,
        'toggleButton' => ['label'=>'<i class="fa fa-search"></i> ' . $searchText,'class'=>'btn btn-warning'],
    ]); ?>
<div class="dict-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
                'data-pjax' => 1,
                'onsubmit' => "\$('#dict-data-search-modal').modal('hide')"
        ],
    ]); ?>
<div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'id') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'dictLabel') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'dictValue') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'dictType') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'listCss') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'isDefault')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'sort') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'status')->dropDownList([ '不可用', '可用', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'createdAt')->widget(DatePicker::class,['multidate'=>2]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'updatedAt')->widget(DatePicker::class,['multidate'=>2]) . '</div>' ?>

</div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i> ' .  Yii::t('da','Search'), ['class' => 'btn btn-warning']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php  Modal::end(); ?>
