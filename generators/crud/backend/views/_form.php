<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\generators\crud\Generator */
/* @var $model \yii\db\ActiveRecord */
/* @var $action array  */

$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
$formName = Inflector::camel2id(StringHelper::basename($generator->modelClass));
?>
<?php $this->beginBlock('form');?>
<div class="<?= $formName ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin(['id'=>'<?= $formName ?>-form','enableAjaxValidation' => true,'action'=>$action]); ?>
    <div class="row">
<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        if(in_array($attribute,['createdAt','updatedAt'])) continue;
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
    </div>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da','Save'), ['class' => 'btn btn-success']) ?>
        <?= "<?= " ?>Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
<?php $this->endBlock();?>
use yii\helpers\Html;
use yii\widgets\ActiveForm;
<?php foreach(array_keys($generator->useFormClassies) as $className): ?>
use <?=$className?>;
<?php endforeach;?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>
<?= $this->blocks['form']?>
