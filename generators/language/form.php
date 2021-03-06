<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator app\generators\language\Generator */

echo $form->field($generator, 'language');
$paths = $generator->getMessagesPaths();
echo $form->field($generator, 'messagesPath')->dropDownList(array_combine($paths,$paths));
$tables = $generator->getTableNames();
echo $form->field($generator, 'tables')->checkboxList(array_combine($tables, $tables));