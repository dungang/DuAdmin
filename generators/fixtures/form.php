<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator app\generators\fixtures\Generator */
echo $form->field($generator, 'language');
$paths = $generator->findFixtureTemplatePaths();
echo $form->field($generator, 'fixtureTemplatePath')->dropDownList(array_combine($paths, $paths));
$tables = $generator->getTableNames();
echo $form->field($generator, 'tables')->checkboxList(array_combine($tables, $tables));