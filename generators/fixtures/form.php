<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator app\generators\fixtures\Generator */
echo $form->field($generator, 'language');
$appNames = $generator->findFixtureAppNames();
echo $form->field($generator, 'appName')->dropDownList(array_combine($appNames, $appNames));
$tables = $generator->getTableNames();
echo $form->field($generator, 'tables')->checkboxList(array_combine($tables, $tables));