<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use DuAdmin\Widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\AdvBlockSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
 
	$searchText = Yii::t('da','Advanced Search');
	\yii\bootstrap\Modal::begin([
        'id' => 'adv-block-search-modal',
        'header' => $searchText,
        'toggleButton' => ['label'=>'<i class="fa fa-search"></i> ' . $searchText,'class'=>'btn btn-warning'],
    ]); ?>
<div class="adv-block-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
                'data-pjax' => 1,
                'onsubmit' => "\$('#adv-block-search-modal').modal('hide')"
        ],
    ]); ?>
<div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'id') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'name') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'nameCode') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'type')->dropDownList([ 'image' => '图片', 'js' => 'js代码', 'html' => 'html代码', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'url') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'content')->textarea(['rows' => 6]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'startedAt')->widget(DatePicker::class,['multidate'=>2]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'endAt')->widget(DatePicker::class,['multidate'=>2]) . '</div>' ?>

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
