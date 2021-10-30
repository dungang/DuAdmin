<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\generators\crud\Generator */

echo "<?php\n";
?>
<?php $this->beginBlock('search');?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">

    <?= "<?php " ?>$form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    <?php if ($generator->enablePjax) : ?>
        'options' => [
        'data-pjax' => 1
        ],
    <?php endif; ?>
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
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::resetButton(<?= $generator->generateString('Reset') ?>, ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
<?php $this->endBlock();?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;
<?php foreach(array_keys($generator->useSearchFormClassies) as $className): ?>
use <?=$className?>;
<?php endforeach;?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>
<?= $this->blocks['search']?>