<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\kit\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model app\backend\forms\DynamicUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id'=>'user-form','enableAjaxValidation' => true]); ?>

    <div class="row">
		<div class="col-md-6">
        	<?= $form->field($model->model, 'username')->textInput() ?>
            <?= $form->field($model->model, 'nick_name')->textInput() ?>
            <?= $form->field($model->model, 'password')->textInput(['autocomplete'=>'off']) ?>
    		<?= $form->field($model->model, 'is_admin')->checkbox() ?>
    	</div>
		<div class="col-md-6">
            <?= $form->field($model->model, 'email')->textInput() ?>
            <?= $form->field($model->model, 'mobile')->textInput() ?>
            <?=$form->field($model->model, 'status')->dropDownList([0 => '未激活',10 => '已激活'])?>
    		<?= $form->field($model->model, 'is_super')->checkbox() ?>
    	</div>
    	 <?php foreach($model->getDynamicProperties() as $property):?>
    		<div class="col-md-6">
    		<?= $form->field($model, $property->field)->input($property->input_type) ?>
    		</div>
    	<?php endforeach;?>
		<div class="col-md-12">
    	<?= $form->field($model->model, 'role')->radioList(AuthItem::allIdToName('name','name',['type'=>1])) ?>
    	</div>
	</div>

	<div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
