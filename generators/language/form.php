<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator app\generators\language\Generator */

echo $form->field($generator, 'language');
$paths = $generator->getMessagesPaths();
$dirs = array_keys($paths);
$messages = array_values($paths);
echo $form->field($generator, 'messagesPath')->dropDownList(array_combine($dirs,$dirs));
echo $form->field($generator, 'messagesCategory')->dropDownList(array_combine($messages,$messages));
$tables = $generator->getTableNames();
echo $form->field($generator, 'tables')->checkboxList(array_combine($tables, $tables));