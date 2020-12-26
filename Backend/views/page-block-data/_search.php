<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use DuAdmin\Widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\PageBlockDataSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php  \yii\bootstrap\Modal::begin([
        'id' => 'page-block-data-search-modal',
        'header' => '高级搜索',
        'toggleButton' => ['label'=>'<i class="fa fa-search"></i> 高级搜索','class'=>'btn btn-warning'],
    ]); ?>
<div class="page-block-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
                'data-pjax' => 1,
                'onsubmit' => "\$('#page-block-data-search-modal').modal('hide')"
        ],
    ]); ?>
<div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'id') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'blockId') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'showTitle') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'filter') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'size') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'orderBy') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'style') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enableCache')->dropDownList([ 1 => '是', 0 => '否', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'expiredAt')->widget(DatePicker::class,['multidate'=>2]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'sort') . '</div>' ?>

</div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i> ' .  Yii::t('da','Search'), ['class' => 'btn btn-warning']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php  Modal::end(); ?>
