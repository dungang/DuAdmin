<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use DuAdmin\Widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\GenTableSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
 
	$searchText = Yii::t('da','Advanced Search');
	\yii\bootstrap\Modal::begin([
        'id' => 'gen-table-search-modal',
        'header' => $searchText,
        'toggleButton' => ['label'=>'<i class="fa fa-search"></i> ' . $searchText,'class'=>'btn btn-warning'],
    ]); ?>
<div class="gen-table-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
                'data-pjax' => 1,
                'onsubmit' => "\$('#gen-table-search-modal').modal('hide')"
        ],
    ]); ?>
<div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'id') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'tableName') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'tableComment') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'modelNamespace') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'modelName') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'modelBaseName') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'activeQueryBaseName') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'dbConnectionId') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enableSearchModel')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enableI18n')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'backendControllerNamespace') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'frontendControllerNamespace') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'apiControllerNamespace') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'backendControllerBase') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'frontendControllerBase') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'apiControllerBase') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'controllerName') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'backendViewPath') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'frontendViewPath') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'backendListView') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'frontendistView') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'backendActions') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'frontendActions') . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'modalDailogSize')->dropDownList([ 'def' => '默认窗口', 'sm' => '小窗口', 'lg' => '大窗口', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enableUserData')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enablePjax')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

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
