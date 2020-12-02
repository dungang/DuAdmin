<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
$formName = Inflector::camel2id(StringHelper::basename($generator->modelClass));
?>
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= $formName ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin(['id'=>'<?= $formName ?>-form','enableAjaxValidation' => true]); ?>
    <div class="row">
<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
    </div>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('ma','Save'), ['class' => 'btn btn-success']) ?>
        <?= "<?= " ?>Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('ma','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
