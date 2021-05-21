<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\generators\crud\Generator */

echo "<?php\n";
?>
<?php $this->beginBlock('search');?>
<?= "<?php \n" ?> 
	$searchText = Yii::t('da','Advanced Search');
	\yii\bootstrap\Modal::begin([
        'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search-modal',
        'header' => $searchText,
        'toggleButton' => ['label'=>'<i class="fa fa-search"></i> ' . $searchText,'class'=>'btn btn-warning'],
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

foreach ($generator->getColumnNames() as $attribute) {
    if($fieldInput = $generator->generateActiveSearchField($attribute)) {
        echo "    <?= " . $fieldInput . " ?>\n\n";
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
<?php $this->endBlock();?>
use yii\bootstrap\Modal;
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