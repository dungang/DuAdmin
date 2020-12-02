<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\generators\crud\Generator */

echo "<?php\n";
?>
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>
<?= "<?php " ?> \yii\bootstrap\Modal::begin([
        'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search-modal',
        'header' => '高级搜索',
        'toggleButton' => ['label'=>'<i class="fa fa-search"></i> 高级搜索','class'=>'btn btn-warning'],
    ]); ?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">

    <?= "<?php " ?>$form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
    <?php if ($generator->enablePjax): ?>
            'data-pjax' => 1,
    <?php endif; ?>
            'onsubmit' => "\$('#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search-modal').modal('hide')"
        ],
    ]); ?>
<div class="row">
<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count < 6) {
        echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    } else {
        echo "    <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    }
}
?>
</div>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton('<i class="fa fa-search"></i> ' .  Yii::t('da','Search'), ['class' => 'btn btn-warning']) ?>
        <?= "<?= " ?>Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
<?= "<?php " ?> Modal::end(); ?>