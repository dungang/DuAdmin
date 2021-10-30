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
?>
<?php $this->beginBlock('form'); ?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
    <div class="row">
        <?php foreach ($generator->getColumnNames() as $attribute) {
            if (in_array($attribute, $safeAttributes)) {
                echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
            }
        } ?>
    </div>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Save') ?>, ['class' => 'btn btn-success']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
<?php $this->endBlock(); ?>
use yii\helpers\Html;
use yii\widgets\ActiveForm;
<?php foreach (array_keys($generator->useFormClassies) as $className) : ?>
use <?= $className ?>;
<?php endforeach; ?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array */
?>
<?= $this->blocks['form'] ?>